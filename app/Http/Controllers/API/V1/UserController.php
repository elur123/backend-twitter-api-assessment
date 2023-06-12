<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\FollowedResource;
use App\Http\Resources\FollowerResource;
use App\Http\Resources\TweetResource;
use App\Http\Resources\SuggestionResource;

use App\Models\User;
use App\Models\FollowedUser;
class UserController extends ApiController
{

    public function showAuthenticatedUser()
    {
        $this->user->load(
            'followedUsers.followed', 
            'followerUsers.follower', 
            'tweets.author'
        );

        $followedUsers = FollowedResource::collection($this->user->followedUsers);
        $followerUsers = FollowerResource::collection($this->user->followerUsers);
        $tweets = TweetResource::collection($this->user->tweets);

        $user = $this->user->toArray();
        $user['followed_users'] = $followedUsers;
        $user['follower_users'] = $followerUsers;
        $user['tweets'] = $tweets;

        return response()->json([
            'user' => $user
        ], 200);
    }

    public function show(User $user)
    {
        $user->load(
            'followedUsers.followed', 
            'followerUsers.follower', 
            'tweets.author'
        );

        $followedUsers = FollowedResource::collection($user->followedUsers);
        $followerUsers = FollowerResource::collection($user->followerUsers);
        $tweets = TweetResource::collection($user->tweets);

        $user = $user->toArray();
        $user['followed_users'] = $followedUsers;
        $user['follower_users'] = $followerUsers;
        $user['tweets'] = $tweets;

        return response()->json([
            'user' => $user
        ], 200);
    }

    public function update(UserUpdateRequest $request, User $user)
    {

        $user->update($request->except('password'));

        if (!empty($request->password)) 
        {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }
        
        return $this->show($user);
    }

    public function follower(User $user)
    {
        $user->load('followerUsers.follower');


        return response()->json([
            'followers' =>  FollowerResource::collection($user->followerUsers)
        ], 200);
    }

    public function followed(User $user)
    {
        $user->load('followedUsers.followed.tweets');

        return response()->json([
            'followed' => $user->followedUsers
        ], 200);
    }

    public function suggestion(User $user)
    {
        // Get the IDs of the users already being followed by the logged-in user
        $followedUserIds = $user->followedUsers()
        ->pluck('followed_id')
        ->toArray();

        // Get the suggested users
        $suggestedUsers = User::whereNotIn('id', $followedUserIds)
        ->whereNot('id', $user->id)
        ->get();

        return response()->json([
            'suggestedUsers' => SuggestionResource::collection($suggestedUsers) 
        ], 200);
    }

    public function follow(Request $request, User $user)
    {

        if ($this->user->id === $user->id) 
        {
            return response()->json(['message' => 'Action invalid.'], 500);
        }

        $this->user->followedUsers()->firstOrCreate(
            ['followed_id' => $user->id],
            ['followed_id' => $user->id]
        );

        return $this->show($this->user);
    }

    public function unfollow(Request $request, User $user)
    {
        $this->user->followedUsers()
        ->where('followed_id', $user->id)
        ->delete();

        return $this->show($this->user);
    }
}
