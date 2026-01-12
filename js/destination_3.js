 // Destination data
    const destinations = {
gavi: {
  title: "Gavi, Kerala",
  image: "images/gavi.jpg",
  rating: 4,
  price: "₹9,000",
  duration: "2-3 days",
  description: "Gavi, located in the Periyar Tiger Reserve of Kerala, is an eco-tourism haven known for its pristine forests, lakes, and wildlife. A hidden gem, it offers nature lovers a chance to experience untouched wilderness and serenity.",
  bestTime: "September to February",
  difficulty: "Moderate",
  activities: ["Trekking", "Wildlife Safari", "Boating", "Bird Watching", "Camping"]
},

dzukou_valley: {
  title: "Dzükou Valley, Nagaland-Manipur",
  image: "images/Dzoku_valley.jpg",
  rating: 5,
  price: "₹13,000",
  duration: "3-4 days",
  description: "Dzükou Valley, on the border of Nagaland and Manipur, is famous for its rolling green meadows, seasonal flowers, and breathtaking landscapes. Known as the 'Valley of Flowers of the Northeast', it is a paradise for trekkers and nature enthusiasts.",
  bestTime: "June to September (flower bloom), November to March (clear skies)",
  difficulty: "Moderate to Difficult",
  activities: ["Trekking", "Camping", "Photography", "Nature Walks", "Flora Exploration"]
},

mawlynnong: {
  title: "Mawlynnong, Meghalaya",
  image: "images/Mawlynnong.jpg",
  rating: 4,
  price: "₹7,000",
  duration: "2-3 days",
  description: "Mawlynnong, often called 'Asia’s Cleanest Village', is located in Meghalaya. It is renowned for its cleanliness, living root bridges, and warm Khasi hospitality. The village offers a unique glimpse into sustainable community living.",
  bestTime: "March to June, September to November",
  difficulty: "Easy",
  activities: ["Village Walks", "Root Bridge Visit", "Photography", "Cultural Exploration", "Nature Walks"]
},

tadoba: {
  title: "Tadoba National Park, Maharashtra",
  image: "images/tadoba.png",
  rating: 5,
  price: "₹15,000",
  duration: "3-4 days",
  description: "Tadoba Andhari Tiger Reserve in Maharashtra is one of India’s premier tiger reserves, home to rich biodiversity including tigers, leopards, sloth bears, and a variety of birds. It is a dream destination for wildlife photographers and safari lovers.",
  bestTime: "February to May, October to December",
  difficulty: "Easy",
  activities: ["Wildlife Safari", "Bird Watching", "Photography", "Nature Exploration", "Camping"]
},

lonar_lake: {
  title: "Lonar Lake, Maharashtra",
  image: "images/lonar.jpg",
  rating: 4,
  price: "₹6,000",
  duration: "1-2 days",
  description: "Lonar Lake in Maharashtra is a unique crater lake formed by a meteorite impact around 50,000 years ago. Surrounded by forests and ancient temples, it is a geological wonder attracting scientists, trekkers, and nature lovers.",
  bestTime: "November to February",
  difficulty: "Easy to Moderate",
  activities: ["Trekking", "Temple Exploration", "Bird Watching", "Photography", "Nature Walks"]
},

majuli_island: {
  title: "Majuli Island, Assam",
  image: "images/majuli_island.jpg",
  rating: 5,
  price: "₹12,000",
  duration: "3-4 days",
  description: "Majuli, located on the Brahmaputra River in Assam, is the world’s largest river island. Known for its vibrant Assamese culture, Satras (monasteries), and festivals, Majuli offers a blend of spirituality, tradition, and natural beauty.",
  bestTime: "October to March",
  difficulty: "Easy",
  activities: ["Cultural Exploration", "Boating", "Village Tour", "Photography", "Bird Watching"]
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