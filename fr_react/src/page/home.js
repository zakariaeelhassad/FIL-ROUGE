import React from "react";
import ProfileCard from "../component/Home/profileCard";
import PostsList from "../component/Home/postsList";

function Home() {
    return (
        <div className="bg-gray-100 flex items-start justify-center p-10">
            {/* ProfileCard */}
            <div className="mr-8">
                <ProfileCard />
            </div>

            {/* PostCards */}
            <div className="space-y-6">
                <PostsList />
            </div>
        </div>
    );
}

export default Home;