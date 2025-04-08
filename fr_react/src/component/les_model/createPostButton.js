import React, { useState } from 'react';

function CreatePostButton({ openModal }) {
  const [postContent, setPostContent] = useState('');
  const [postImage, setPostImage] = useState(null);

  const closeModal = () => {
    setPostContent('');
    setPostImage(null);
  };

  const handleImageUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onloadend = () => {
        setPostImage(reader.result);
      };
      reader.readAsDataURL(file);
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log('Post submitted:', { content: postContent, image: postImage });
    closeModal();
  };

  return (
    <div>
      {/* Modal */}
      {openModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
          <div className="bg-white p-6 rounded-lg w-96">
            <h2 className="text-xl font-bold mb-4">Créer un nouveau post</h2>
            <form onSubmit={handleSubmit}>
              <textarea
                value={postContent}
                onChange={(e) => setPostContent(e.target.value)}
                placeholder="Quoi de neuf?"
                className="w-full border rounded p-2 mb-4"
                rows="4"
              />
              <div className="mb-4">
                <label className="block mb-2">Ajouter une image</label>
                <input
                  type="file"
                  accept="image/*"
                  onChange={handleImageUpload}
                  className="w-full"
                />
              </div>
              {postImage && (
                <div className="mb-4">
                  <img src={postImage} alt="Preview" className="max-w-full h-auto rounded" />
                </div>
              )}
              <div className="flex justify-between">
                <button type="button" onClick={closeModal} className="px-4 py-2 bg-gray-200 rounded">
                  Annuler
                </button>
                <button type="submit" className="px-4 py-2 bg-blue-500 text-white rounded">
                  Publier
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}

export default CreatePostButton;
