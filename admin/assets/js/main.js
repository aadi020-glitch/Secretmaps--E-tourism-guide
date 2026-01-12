document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    menuToggle.addEventListener('click', function() {
        sidebar.classList.toggle('closed'); // desktop
        sidebar.classList.toggle('active'); // mobile
    });

            // Page navigation
            pageLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const page = this.getAttribute('data-page');
                    
                    // Handle logout separately
                    if (page === 'logout') {
                        if (confirm('Are you sure you want to logout?')) {
                            window.location.href = '../index.php';
                        }
                        return;
                    }
                    
                    // Update active link
                    pageLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update page title
                    pageTitle.textContent = this.textContent.trim();
                    
                    // Load page content (in a real app, this would fetch HTML)
                    loadPageContent(page);
                    
                    // Close sidebar on mobile after selection
                    if (window.innerWidth < 768) {
                        sidebar.classList.remove('active');
                    }
                });
            });
            
            // Function to load page content
            function loadPageContent(page) {
                // In a real application, you would fetch HTML content from the server
                // For this example, we'll simulate with simple content
                
                let content = '';
                
               switch(page) {
                    case 'dashboard':
                        window.location.href = "index.php";
                        break;
                    case 'profile':
                        window.location.href = "profile.php";
                        break;
                    case 'Gallery':
                        window.location.href = "gallery.php";
                        break;
                    case 'customer':
                        window.location.href = "customer.php";
                        break;
                    case 'places':
                        window.location.href = "places.php";
                        break;
                    default:
                      //  window.location.href = "404.html";
                }

                
                contentArea.innerHTML = content;
            }
        });