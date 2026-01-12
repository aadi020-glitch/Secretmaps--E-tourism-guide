 // Destination data
    const destinations = {
    amboli: {
  title: "Amboli, Maharashtra",
  image: "images/amboli.jpg",
  rating: 4,
  price: "₹8,000",
  duration: "2-3 days",
  description: "Amboli, a hill station in the Sahyadri ranges of Maharashtra, is famous for its lush green forests, misty waterfalls, and rich biodiversity. Known as the 'Cherrapunji of Maharashtra', it is a paradise for nature lovers and photographers.",
  bestTime: "June to September (monsoon), November to February (winter)",
  difficulty: "Easy",
  activities: ["Trekking", "Waterfalls Visit", "Nature Walks", "Photography", "Bird Watching"]
},

velas: {
  title: "Velas, Maharashtra",
  image: "images/velas.jpg",
  rating: 4,
  price: "₹6,000",
  duration: "2-3 days",
  description: "Velas is a small coastal village in Ratnagiri, Maharashtra, famous for its Olive Ridley turtle conservation project. Tourists flock here to witness baby turtles being released into the sea, along with enjoying serene beaches and Konkani hospitality.",
  bestTime: "February to April (during Turtle Festival)",
  difficulty: "Easy",
  activities: ["Turtle Watching", "Beach Walks", "Village Tour", "Photography", "Nature Exploration"]
},

saputara: {
  title: "Saputara, Gujarat",
  image: "images/saputara.jpg",
  rating: 4,
  price: "₹10,000",
  duration: "2-3 days",
  description: "Saputara, located in the Western Ghats of Gujarat, is the only hill station of the state. Surrounded by dense forests, lakes, and tribal culture, it is a perfect weekend getaway for nature lovers and adventure seekers.",
  bestTime: "March to November",
  difficulty: "Easy",
  activities: ["Boating", "Cable Car Ride", "Trekking", "Tribal Culture Tour", "Photography"]
},

agumbe: {
  title: "Agumbe, Karnataka",
  image: "images/agumbe.jpg",
  rating: 4,
  price: "₹9,000",
  duration: "3-4 days",
  description: "Known as the 'Cherrapunji of the South', Agumbe in Karnataka is famous for its heavy rainfall, lush rainforests, and stunning sunsets. It is also home to the King Cobra and has inspired the setting for 'Malgudi Days'.",
  bestTime: "November to February, June to September (for monsoon lovers)",
  difficulty: "Moderate",
  activities: ["Trekking", "Waterfalls Visit", "Wildlife Watching", "Photography", "Nature Trails"]
},

araku_valley: {
  title: "Araku Valley, Andhra Pradesh",
  image: "images/arakku_valley.jpg",
  rating: 5,
  price: "₹12,000",
  duration: "3-4 days",
  description: "Araku Valley, nestled in the Eastern Ghats near Visakhapatnam, is a picturesque valley known for its coffee plantations, tribal culture, and breathtaking landscapes. The train journey to Araku through tunnels and bridges is a highlight for tourists.",
  bestTime: "October to March",
  difficulty: "Easy",
  activities: ["Coffee Plantation Tour", "Trekking", "Caves Exploration", "Photography", "Tribal Culture Experience"]
},

kolukkumalai: {
  title: "Kolukkumalai, Tamil Nadu",
  image: "images/kolukumalai.jpg",
  rating: 5,
  price: "₹14,000",
  duration: "2-3 days",
  description: "Kolukkumalai, near Munnar, is the world’s highest tea plantation located at 7,900 feet. Known for its scenic jeep rides, breathtaking sunrise views, and aromatic tea, it offers a blend of adventure and serenity.",
  bestTime: "September to May",
  difficulty: "Moderate",
  activities: ["Tea Estate Tour", "Jeep Safari", "Trekking", "Sunrise View", "Photography"]
}
    };

    // Get modal element
    const modal = document.getElementById('destinationModal');
    
    // Get all discover links
    const discoverLinks = document.querySelectorAll('.discover-link');
    
    // Get close button
    const closeBtn = document.querySelector('.close-modal');
    
    // Function to open modal with destination data
    function openModal(destinationKey) {
      const destination = destinations[destinationKey];
      
      if (destination) {
        document.getElementById('modalImage').src = destination.image;
        document.getElementById('modalTitle').textContent = destination.title;
        
        // Generate star rating
        let ratingHTML = '';
        for (let i = 1; i <= 5; i++) {
          if (i <= destination.rating) {
            ratingHTML += '<i class="icon-star"></i>';
          } else {
            ratingHTML += '<i class="icon-star-o"></i>';
          }
        }
        ratingHTML += `<span> ${destination.rating} Rating</span>`;
        document.getElementById('modalRating').innerHTML = ratingHTML;
        
        document.getElementById('modalDescription').textContent = destination.description;
        document.getElementById('modalPrice').textContent = destination.price;
        document.getElementById('modalDuration').textContent = destination.duration;
        document.getElementById('modalBestTime').textContent = destination.bestTime;
        document.getElementById('modalDifficulty').textContent = destination.difficulty;
        
        // Generate activities
        let activitiesHTML = '';
        destination.activities.forEach(activity => {
          activitiesHTML += `<span class="activity">${activity}</span>`;
        });
        document.getElementById('modalActivities').innerHTML = activitiesHTML;
        
        // Show modal
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevent scrolling
      }
    }
    
    // Add click event to all discover links
    discoverLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const destinationKey = this.getAttribute('data-destination');
        openModal(destinationKey);
      });
    });
    
    // Close modal when clicking on close button
    closeBtn.addEventListener('click', function() {
      modal.style.display = 'none';
      document.body.style.overflow = 'auto'; // Enable scrolling
    });
    
    // Close modal when clicking outside of modal content
    window.addEventListener('click', function(e) {
      if (e.target === modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Enable scrolling
      }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && modal.style.display === 'block') {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Enable scrolling
      }
    });