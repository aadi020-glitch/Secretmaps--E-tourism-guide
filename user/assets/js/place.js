        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const file = input.files[0];
            const reader = new FileReader();
            
            preview.innerHTML = '';
            
            reader.onloadend = function() {
                const img = document.createElement('img');
                img.src = reader.result;
                preview.appendChild(img);
            }
            
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = `
                    <div class="image-preview-placeholder">
                        <i class="fas fa-mountain"></i>
                        <p>Image preview will appear here</p>
                    </div>
                `;
            }
        }
        
        document.getElementById('destinationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = document.getElementById('destinationName').value;
            const description = document.getElementById('destinationDescription').value;
            const location = document.getElementById('destinationLocation').value;
            const country = document.getElementById('destinationCountry').value;
            const category = document.getElementById('destinationCategory').value;
            const price = document.getElementById('destinationPrice').value;
            const bestTime = document.getElementById('destinationBestTime').value;
            const imagePreview = document.getElementById('imagePreview').querySelector('img');
            
            // Create new destination card
            const destinationCard = document.createElement('div');
            destinationCard.className = 'destination-card';
            
            destinationCard.innerHTML = `
                <div class="destination-image">
                    <img src="${imagePreview ? imagePreview.src : 'https://images.unsplash.com/photo-1418065460487-3e41a6c84dc5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600&q=80'}" alt="${name}">
                </div>
                <div class="destination-info">
                    <h3>${name}</h3>
                    <p>${description}</p>
                    <div class="destination-meta">
                        <span><i class="fas fa-map-marker-alt"></i> ${location}</span>
                        <span><i class="fas fa-dollar-sign"></i> ${price || 'N/A'}/day</span>
                    </div>
                    <div class="destination-actions">
                        <button class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</button>
                        <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
                    </div>
                </div>
            `;
            
            // Add to container
            document.getElementById('destinationsContainer').prepend(destinationCard);
            
            // Reset form
            document.getElementById('destinationForm').reset();
            document.getElementById('imagePreview').innerHTML = `
                <div class="image-preview-placeholder">
                    <i class="fas fa-mountain"></i>
                    <p>Image preview will appear here</p>
                </div>
            `;
            
            // Show success message
            alert('Destination added successfully!');
        });
        
        // Add event delegation for delete buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
                if (confirm('Are you sure you want to delete this destination?')) {
                    const card = e.target.closest('.destination-card');
                    card.remove();
                    alert('Destination deleted successfully!');
                }
            }
        });
