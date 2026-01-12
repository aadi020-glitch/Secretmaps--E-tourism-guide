 function previewImage(input) {
            const preview = document.getElementById('avatarPreview');
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onloadend = function() {
                preview.src = reader.result;
            }
            
            if (file) {
                reader.readAsDataURL(file);
            }
        }
        
        function updateProfile() {
            // Get updated values
            const name = document.getElementById('name').value;
            const position = document.getElementById('position').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const location = document.getElementById('location').value;
            
            // Update profile header
            document.getElementById('profileName').textContent = name;
            
            // Show success message
            alert('Profile updated successfully!');
            
            // In a real application, you would send this data to a server
            console.log('Profile updated:', {name, position, email, phone, location});
        }
        
        function resetForm() {
            document.getElementById('name').value = 'Admin User';
            document.getElementById('position').value = 'Senior Administrator';
            document.getElementById('email').value = 'admin@tourismwebsite.com';
            document.getElementById('phone').value = '+1 234 567 8900';
            document.getElementById('location').value = 'New York, USA';
            
            // Reset avatar preview
            document.getElementById('avatarPreview').src = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=200&q=80';
            
            alert('Changes have been reset');
        }