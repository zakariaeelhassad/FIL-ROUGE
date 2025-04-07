import React from "react";
import InvitationsList from "./follow";
import PeopleList from "./follower";

function Reseau() {
    return (
        <div className="bg-gray-100 p-6">
            <div className="max-w-2xl mx-auto">
                <InvitationsList />
                <PeopleList />
            </div>
        </div>
    );
}

export default Reseau;