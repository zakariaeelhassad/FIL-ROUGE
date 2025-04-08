import React from "react";
import InvitationsList from "../component/reseau/follow";
import PeopleList from "../component/reseau/follower";

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