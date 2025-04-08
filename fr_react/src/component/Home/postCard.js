import React from "react";
import LikeButton from "./likePost";

const PostCard = ({ post }) => {
    const { user = {}, content, image, created_at } = post; 

    return (
        <div className="w-[500px] bg-white rounded-3xl border border-blue-400 shadow-md p-6">
            {/* Header: User Details */}
            <div className="flex items-center mb-4">
                <img
                    src={user.profile_image || "https://placehold.co/40x40"}
                    alt="Profile"
                    className="rounded-full w-10 h-10 object-cover mr-3"
                />
                <div>
                    <h3 className="text-blue-500 font-bold">{user.name || "Unknown User"}</h3>
                    <p className="text-gray-500 text-sm">{user.bio || "No Bio Available"}</p>
                    <div className="text-gray-400 text-xs mb-4">
                        Posted on: {new Date(created_at).toLocaleString() || "Unknown Date"}
                    </div>
                </div>
            </div>

            {/* Post Content */}
            <div className="text-gray-800 text-sm mb-4">
                <p>{content}</p>
                <span className="text-blue-500 italic cursor-pointer">voir plus</span>
            </div>

            {/* Post Image */}
            <div className="w-full h-40 bg-gray-200 mb-4 rounded-lg overflow-hidden">
                <img
                    src={image || "https://placehold.co/400x200"}
                    alt="Post Media"
                    className="w-full h-full object-cover"
                />
            </div>

            <div className="flex justify-between">
                <LikeButton postId={post.id} initialLiked={post.initialLiked} />
                <button className="rounded-full border border-blue-300 p-2 w-20 flex justify-center hover:bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </button>
                <button className="rounded-full border border-blue-300 p-2 w-20 flex justify-center hover:bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </div>
        </div>
    );
};

export default PostCard;

