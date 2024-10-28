<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Post;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\fileExists;

class PostController extends Controller
{

    public function postlist()
    {
        $post = Post::all();
        return view('panel.admin.allpost', compact('post'));
    }

    public function addpost()
    {
        $post = Categorie::all();
        return view('panel.user.addpost', compact('post'));
    }
    public function showpost()
    {
        $user = Auth::user()->id;
        $posts = Post::where('user_id', $user)->get();
        $role = Categorie::all();
        return view('panel.user.postlist', compact(['posts', 'role']));
    }

    public function insertpost(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required',
        ]);

        $file = $request->file('image');
        $path = $request->file('image')->store('image', 'public');

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->desc,
            'image' => $path,
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
        ]);
        if ($post) {
            return redirect()->route('postlist')->with('success', 'add post succesfully');
        } else {
            return redirect()->route('postlist')->with('error', 'add post failed');
        }
    }

    public function editpost($id)
    {
        $post = Post::find($id);
        return response()->json([
            'status' => 'success',
            'post' => $post,
        ]);
    }

    public function updatepost(Request $request)
    {
        $postid = $request->input('post_id');
        $data = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required',
        ]);

        $post = Post::find($postid);
        $path = $post->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $request->file('image')->store('image', 'public');
        }
        $postupdate = $post->update([
            'title' => $request->title,
            'description' => $request->desc,
            'image' => $path,
            'category_id' => $request->category_id,
        ]);

        if ($postupdate) {
            return redirect()->route('postlist')->with('success', 'update post succesfully');
        } else {
            return redirect()->route('postlist')->with('error', 'update post failed');
        }
    }

    public function deletepost($id)
    {
        $post = Post::find($id);
        $post->delete();

        $filepath = public_path('storage/') . $post->image;

        if (fileExists($filepath)) {
            unlink($filepath);
        }

        return redirect()->route('postlist')->with('success', 'delete post succesfully');
    }

    public function admindeletepost($id)
    {
        $post = Post::find($id);
        $post->delete();

        $filepath = public_path('storage/') . $post->image;

        if (fileExists($filepath)) {
            unlink($filepath);
        }

        return redirect()->route('allpost')->with('success', 'delete post succesfully');
    }

    public function adminpostapprove($id)
    {
        $post = Post::find($id);
        if ($post) {
            if ($post->status) {
                $post->status = 0;
            } else {
                $post->status = 1;
            }
        }
        $post->save();

        return redirect()->route('allpost')->with('success', 'Approve post succesfully');
    }

    public function displaypost(Request $request)
    {
        $category = Categorie::all();
        $query = Post::where('status', 1);

        $data = $request->validate([
            'sdate' => 'nullable|date',
            'edate' => 'nullable|date|after:sdate',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        if ($request->filled('sdate') && $request->filled('edate')) {
            $sdate = $request->input('sdate');
            $edate = Carbon::parse($request->input('edate'))->endOfDay();
            $query->whereBetween('created_at', [$sdate, $edate]);
        }

        if ($request->filled('categories')) {
            $categories = $request->input('categories');
            $query->where('category_id', $categories);
        }

        if ($request->filled('rating')) {
            $rating = $request->input('rating');
            $query->whereHas('review', function ($q) use ($rating) {
                $q->selectRaw('AVG(rate)')
                    ->havingRaw('AVG(rate)=?', [$rating]);
                // ->where('AVG(rate)', $rating);
            });
        }
        $post = $query->get();
        return view('welcome', compact(['post', 'category']));
    }


    public function viewallpost()
    {
        $posts = Post::where('status', 1)->skip(8)->take(PHP_INT_MAX)->get();
        $html = '';

        foreach ($posts as $post) {
            $sum = $post->review->sum('rate');
            $count = $post->review->count();
            if ($count) {
                $reviews = $sum / $count;
            } else {
                $reviews = 0;
            }

            $fullstar = floor($reviews);
            $halfstar = $reviews - $fullstar >= 0.5 ? 1 : 0;
            $emptystar = 5 - ($fullstar + $halfstar);
            //dd($reviews);
            // $review = review($posts->id);
            $html .= '
            <div class="card shadow ms-3 mb-3" style="width: 18rem;">
                <div class="img" style="height: 200px">
                    <img src="' . asset('storage/' . $post->image) . '" class="card-img-top mt-3" alt="...">
                </div>
                <div class="card-body" style="height: 200px">
                    <h5 class="card-title" style="height: 60px; overflow: hidden;">' . $post->title . '</h5>
                    <a href="' . route('readmore', $post->id) . '" class="btn btn-primary  h-25">Read more</a>
                   <div class="star-rating">';

            for ($i = 1; $i <= $fullstar; $i++)
                $html .= '<i class="fa fa-star" style="color: gold;"></i>';

            if ($halfstar)
                $html .= '<i class="fa fa-star-half-o" style="color: gold;"></i>';

            for ($i = 1; $i <= $emptystar; $i++)
                $html .= '<i class="fa fa-star-o" style="color: gold;"></i>';

            $html .= '
                            </div>
                </div>
            </div>';
        }

        // Return the generated HTML as a JSON response
        return response()->json(['html' => $html]);
    }

    public function readmore($id)
    {
        $post = Post::find($id);
        return view('readmore', compact('post'));
    }

    public function reviewpost(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'name' => 'required',
            'rating' => 'required',
            'review' => 'required',
        ]);

        $post = Review::create([
            'post_id' => $request->post_id,
            'name' => $request->name,
            'rate' => $request->rating,
            'review_text' => $request->review
        ]);
        if ($post) {
            return response()->json('success');
        } else {
            return response()->json('error');
        }
    }
}
