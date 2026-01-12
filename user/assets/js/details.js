    // Function to open Add Modal
            function openAddModal() {
                document.getElementById('modalTitle').textContent = 'Add Destination';
                document.getElementById('destinationForm').reset();
                document.getElementById('destinationId').value = '';
                document.getElementById('destinationModal').style.display = 'block';
            }
            
            // Function to open Edit Modal
            function openEditModal(id) {
                document.getElementById('modalTitle').textContent = 'Edit Destination';
                
                // In a real application, you would fetch the data for this ID from a database
                // For demonstration, we're using placeholder data based on the ID
                const row = document.querySelector(`.destination-table tr:nth-child(${id + 1})`);
                
                document.getElementById('destinationId').value = id;
                document.getElementById('location').value = row.cells[1].textContent;
                document.getElementById('details').value = row.cells[2].textContent;
                document.getElementById('bestTime').value = row.cells[3].textContent;
                
                document.getElementById('destinationModal').style.display = 'block';
            }
            
            // Function to close Modal
            function closeModal() {
                document.getElementById('destinationModal').style.display = 'none';
            }
            
            // Function to open Delete Confirmation Modal
            function deleteDestination(id) {
                document.getElementById('deleteModal').style.display = 'block';
                document.getElementById('confirmDeleteBtn').onclick = function() {
                    // In a real application, you would send a request to delete this record
                    alert('Destination with ID ' + id + ' would be deleted in a real application.');
                    closeDeleteModal();
                };
            }
            
            // Function to close Delete Confirmation Modal
            function closeDeleteModal() {
                document.getElementById('deleteModal').style.display = 'none';
            }
            
            // Handle form submission
            document.getElementById('destinationForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const id = document.getElementById('destinationId').value;
                const location = document.getElementById('location').value;
                const details = document.getElementById('details').value;
                const bestTime = document.getElementById('bestTime').value;
                
                if (id) {
                    // Editing existing destination
                    alert('Destination with ID ' + id + ' would be updated in a real application.');
                } else {
                    // Adding new destination
                    alert('New destination would be saved in a real application.');
                }
                
                closeModal();
            });
            
            // Close modals if user clicks outside
            window.onclick = function(event) {
                const modal = document.getElementById('destinationModal');
                const deleteModal = document.getElementById('deleteModal');
                
                if (event.target == modal) {
                    closeModal();
                }
                
                if (event.target == deleteModal) {
                    closeDeleteModal();
                }
            };
  