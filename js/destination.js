 // Destination data
    const destinations = {
      chopta: {
        title: "Chopta, Uttarakhand",
        image: "images/chopta.jpg",
        rating: 4,
        price: "₹12,000",
        duration: "3-4 days",
        description: "Known as the 'Mini Switzerland of India', Chopta offers a serene alternative to crowded hill stations like Auli and Manali. Nestled in the Garhwal Himalayas, this pristine destination is the base for trekking to Tungnath, the highest Shiva temple in the world, and Chandrashila peak which offers panoramic views of Himalayan giants like Nanda Devi, Trishul, and Chaukhamba.",
        bestTime: "March to June, September to November",
        difficulty: "Moderate",
        activities: ["Trekking", "Bird Watching", "Camping", "Photography", "Nature Walks"]
      },
      kalpa: {
        title: "Kalpa, Himachal Pradesh",
        image: "images/kalpa.jpg",
        rating: 4,
        price: "₹9,000",
        duration: "2-4 days",
        description: "Kalpa is a picturesque village in the Kinnaur district, renowned for its ancient temples and breathtaking views of the Kinner Kailash range. The village offers a glimpse into the rich cultural heritage of Kinnaur, with its traditional wooden houses and apple orchards. The Sutlej River flowing through the deep valleys adds to the majestic beauty of this Himalayan gem.",
        bestTime: "April to June, September to November",
        difficulty: "Easy",
        activities: ["Temple Visits", "Apple Orchards Tour", "Sunset Viewing", "Village Walks", "Cultural Exploration"]
      },
      tirthan: {
        title: "Tirthan Valley, Himachal Pradesh",
        image: "images/tirthan_valley.jpg",
        rating: 4.5,
        price: "₹10,000",
        duration: "4 days",
        description: "Tirthan Valley is a 'Hidden Himalayan Gem' named after the Tirthan River that flows through it. Located near the Great Himalayan National Park (a UNESCO World Heritage Site), this tranquil destination is perfect for those seeking peace amidst nature. The valley is known for its pristine waters, rich biodiversity, and opportunities for trout fishing.",
        bestTime: "March to June, September to November",
        difficulty: "Easy to Moderate",
        activities: ["Trout Fishing", "Trekking", "River Side Camping", "Village Homestays", "Wildlife Spotting"]
      },
      pangot: {
        title: "Pangot, Uttarakhand",
        image: "images/panghot.jpg",
        rating: 4,
        price: "₹10,000",
        duration: "3-4 days",
        description: "Pangot is a serene Himalayan retreat, perfect for bird enthusiasts seeking tranquility away from the crowds. Located just 15 km from Nainital, this quaint village is nestled in a dense oak and rhododendron forest that is home to over 200 bird species. The peaceful environment and panoramic views of the Himalayas make it an ideal destination for nature lovers.",
        bestTime: "Throughout the year, best from September to June",
        difficulty: "Easy",
        activities: ["Bird Watching", "Nature Walks", "Forest Trekking", "Photography", "Stargazing"]
      },
      karsog: {
        title: "Karsog Valley, Himachal Pradesh",
        image: "images/karsog_valley.jpg",
        rating: 3.5,
        price: "₹9,000",
        duration: "3 days",
        description: "Karsog Valley is known for its apple orchards, ancient temples, and tranquil landscapes. This serene retreat in the heart of Himachal Pradesh offers a perfect blend of natural beauty and cultural heritage. The valley is dotted with historic temples like Mamleshwar Mahadev and Kamaksha Devi, which attract devotees and history enthusiasts alike.",
        bestTime: "March to June, September to November",
        difficulty: "Easy",
        activities: ["Temple Visits", "Apple Orchards Tour", "Village Exploration", "Trekking", "Cultural Experiences"]
      },
      banswara: {
        title: "Banswara, Rajasthan",
        image: "images/banswara.jpg",
        rating: 4,
        price: "₹10,000",
        duration: "4 days",
        description: "Banswara, known as 'The City of Hundred Islands', offers a serene blend of lush greenery, tranquil lakes, and rich tribal culture. Located in southern Rajasthan, this offbeat destination is characterized by its unique topography of islands on the Mahi River and its vibrant Bhil tribal culture. The region's numerous ancient temples and palaces reflect its historical significance.",
        bestTime: "October to March",
        difficulty: "Easy",
        activities: ["Island Visiting", "Tribal Culture Experience", "Temple Tours", "Boating", "Nature Walks"]
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