import React from "react";
import ProfileCard from "./profileCard";
import PostCard from "./postCard";

function Home() {
    return (
        <div className="bg-gray-100 flex items-start justify-center p-10">
            {/* ProfileCard */}
            <div className="mr-8">
                <ProfileCard />
            </div>

            {/* PostCards */}
            <div className="space-y-6">
                <PostCard />
                <PostCard />
            </div>
        </div>
    );
}

export default Home;