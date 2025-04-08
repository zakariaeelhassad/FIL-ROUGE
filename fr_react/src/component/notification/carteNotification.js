import React from "react";

const posts = [
    {
        id: 1,
        name: "CRISTIANO RONALDO",
        text: "a publié un post : nsfjhf nefbf fefbehhfbf bjsefbne n jkerf nejkbferjn jbrekfjbr jbrejkjb jkbrjkjbfe rkjfbkjef ...",
    },
    {
        id: 2,
        name: "CRISTIANO RONALDO",
        text: "a commenté dans ton post : \" hvdjh da vjd ghi usdj dzg ld dza lz aadojy oz \"",
    },
    {
        id: 3,
        name: "CRISTIANO RONALDO",
        text: "vy",
    },
    {
        id: 4,
        name: "CRISTIANO RONALDO",
        text: "",
    },
];

const CarteNotification = () => {
    return (
        <div className="border-2 border-blue-400 rounded-2xl overflow-hidden mb-6">
            <div className="p-6">
                <h2 className="text-2xl font-bold text-indigo-950 mb-4">
                    Personnes que vous connaissez
                </h2>
                {posts.map((post) => (
                    <div
                        key={post.id}
                        className="border-2 border-blue-400 rounded-full overflow-hidden mb-4 p-3 flex justify-between items-center"
                    >
                        <div className="flex items-center min-w-0">
                            <div className="w-12 h-12 rounded-full overflow-hidden mr-3 flex-shrink-0">
                                <img
                                    src="https://placehold.co/100x100/36B3F9/ffffff.png?text=CR"
                                    alt="Photo de profil"
                                    className="w-full h-full object-cover"
                                />
                            </div>
                            <div className="min-w-0">
                                <p className="font-bold text-blue-500">{post.name}</p>
                                {post.text && <p className="text-sm text-gray-700">{post.text}</p>}
                            </div>
                        </div>
                        <div className="flex-shrink-0 ml-2">
                            <button className="text-gray-600 font-bold">...</button>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default CarteNotification;