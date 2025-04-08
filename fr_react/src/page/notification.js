import React from "react";
import FilterButtons from "../component/notification/filter";
import CarteNotification from "../component/notification/carteNotification";

function Notification(){
    return (
        <div className="max-w-3xl mx-auto mt-4 p-4">
            <FilterButtons />
            <CarteNotification />
        </div>
    );
}

export  default Notification ;