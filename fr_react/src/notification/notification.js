import React from "react";
import FilterButtons from "./filter";
import CarteNotification from "./carteNotification";

function Notification(){
    return (
        <div className="max-w-3xl mx-auto mt-4 p-4">
            <FilterButtons />
            <CarteNotification />
        </div>
    );
}

export  default Notification ;