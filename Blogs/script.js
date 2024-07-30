document.addEventListener("DOMContentLoaded", () => {
    const addImageBtn = document.getElementById('addImageBtn');
    const passwordPrompt = document.getElementById('passwordPrompt');
    const imageForm = document.getElementById('imageForm');
    const passwordInput = document.getElementById('passwordInput');
    const submitPasswordBtn = document.getElementById('submitPasswordBtn');
    const closeButtons = document.querySelectorAll('.close');
    const uploadForm = document.getElementById('uploadForm');
    const imagesContainer = document.getElementById('imagesContainer');

    const correctPassword = 'A123';
    let authenticated = false;

    // Function to fetch and display existing images
    function fetchExistingImages() {
        fetch('fetch_images.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(image => {
                const imgWrapper = document.createElement('div');
                imgWrapper.className = 'imageWrapper';

                const img = document.createElement('img');
                img.src = image.filePath;
                imgWrapper.appendChild(img);

                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'deleteBtn';
                deleteBtn.innerText = 'Delete';
                deleteBtn.addEventListener('click', () => {
                    if (!authenticated) {
                        alert('You must enter the correct password to delete an image.');
                        return;
                    }

                    fetch('delete.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ filePath: image.filePath })
                    })
                    .then(response => response.text())
                    .then(result => {
                        if (result === 'success') {
                            imgWrapper.remove();
                        } else {
                            alert('Failed to delete image');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
                imgWrapper.appendChild(deleteBtn);

                const updateBtn = document.createElement('button');
                updateBtn.className = 'updateBtn';
                updateBtn.innerText = 'Update';
                updateBtn.addEventListener('click', () => {
                    if (!authenticated) {
                        alert('You must enter the correct password to update an image.');
                        return;
                    }

                    const newImageInput = document.createElement('input');
                    newImageInput.type = 'file';
                    newImageInput.addEventListener('change', () => {
                        const updateFormData = new FormData();
                        updateFormData.append('newImage', newImageInput.files[0]);
                        updateFormData.append('oldFilePath', image.filePath);
                        
                        fetch('update.php', {
                            method: 'POST',
                            body: updateFormData
                        })
                        .then(response => response.text())
                        .then(newFilePath => {
                            if (newFilePath.startsWith('uploads/')) {
                                img.src = newFilePath;
                                imgWrapper.querySelector('img').src = newFilePath;
                            } else {
                                alert('Failed to update image');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    });
                    newImageInput.click();
                });
                imgWrapper.appendChild(updateBtn);

                imagesContainer.appendChild(imgWrapper);
            });
        })
        .catch(error => console.error('Error fetching images:', error));
    }

    // Load existing images when the page loads
    fetchExistingImages();

    addImageBtn.addEventListener('click', () => {
        passwordPrompt.style.display = 'block';
    });

    submitPasswordBtn.addEventListener('click', () => {
        if (passwordInput.value === correctPassword) {
            authenticated = true;
            passwordPrompt.style.display = 'none';
            imageForm.style.display = 'block';
        } else {
            alert('Incorrect password');
        }
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            button.parentElement.parentElement.style.display = 'none';
        });
    });

    uploadForm.addEventListener('submit', (event) => {
        event.preventDefault();
        if (!authenticated) {
            alert('You must enter the correct password to upload an image.');
            return;
        }

        const formData = new FormData(uploadForm);

        fetch('upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Response from server:', data); // Log the response for debugging
            if (data.startsWith('uploads/')) {
                const imgWrapper = document.createElement('div');
                imgWrapper.className = 'imageWrapper';
                
                const img = document.createElement('img');
                img.src = data;
                imgWrapper.appendChild(img);

                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'deleteBtn';
                deleteBtn.innerText = 'Delete';
                deleteBtn.addEventListener('click', () => {
                    if (!authenticated) {
                        alert('You must enter the correct password to delete an image.');
                        return;
                    }

                    fetch('delete.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ filePath: data })
                    })
                    .then(response => response.text())
                    .then(result => {
                        if (result === 'success') {
                            imgWrapper.remove();
                        } else {
                            alert('Failed to delete image');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
                imgWrapper.appendChild(deleteBtn);

                const updateBtn = document.createElement('button');
                updateBtn.className = 'updateBtn';
                updateBtn.innerText = 'Update';
                updateBtn.addEventListener('click', () => {
                    if (!authenticated) {
                        alert('You must enter the correct password to update an image.');
                        return;
                    }

                    const newImageInput = document.createElement('input');
                    newImageInput.type = 'file';
                    newImageInput.addEventListener('change', () => {
                        const updateFormData = new FormData();
                        updateFormData.append('newImage', newImageInput.files[0]);
                        updateFormData.append('oldFilePath', data);
                        
                        fetch('update.php', {
                            method: 'POST',
                            body: updateFormData
                        })
                        .then(response => response.text())
                        .then(newFilePath => {
                            if (newFilePath.startsWith('uploads/')) {
                                img.src = newFilePath;
                                imgWrapper.querySelector('img').src = newFilePath;
                            } else {
                                alert('Failed to update image');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    });
                    newImageInput.click();
                });
                imgWrapper.appendChild(updateBtn);

                imagesContainer.appendChild(imgWrapper);
                imageForm.style.display = 'none';
                uploadForm.reset();
            } else {
                alert('Image upload failed: ' + data);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
