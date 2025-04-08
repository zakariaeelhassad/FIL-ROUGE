import React, { useState } from 'react';

const LikeButton = ({ postId, initialLiked }) => {
    const [isLiked, setIsLiked] = useState(initialLiked);
    const [message, setMessage] = useState('');

    const handleLike = async () => {
        try {
            const response = await fetch(`http://localhost:8000/api/like/post/${postId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            });
    
            console.log('Response status:', response.status);
            if (!response.ok) {
                const text = await response.text(); 
                console.error('Response error:', text);
                throw new Error('Network response was not ok');
            }
    
            const data = await response.json();
            console.log('Response data:', data);
    
            if (data.message === 'Like ajouté avec succès') {
                setIsLiked(true);
                setMessage('Rah darti like!');
            } else if (data.message === 'Like supprimé avec succès') {
                setIsLiked(false);
                setMessage('Rah hiydit lik!');
            } else {
                console.error('Unexpected response:', data);
            }
        } catch (error) {
            console.error('Error during fetch:', error);
            setMessage('Chna moshkil, 7awel 3awd!');
        }
    };

    return (
        <div>
            <button
                className={`rounded-full border border-blue-300 p-2 w-20 flex justify-center ${isLiked ? 'bg-blue-50' : ''}`}
                onClick={handleLike}
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    className={`h-5 w-5 ${isLiked ? 'text-blue-500' : 'text-gray-500'}`}
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="2"
                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"
                    />
                </svg>
            </button>
            {message && <div className="mt-2 text-sm text-blue-600">{message}</div>} {/* Show message if exists */}
        </div>
    );
};

export default LikeButton;