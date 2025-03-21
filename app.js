document.addEventListener("DOMContentLoaded", function () {
    // Function to load room details and add "Book Now" buttons dynamically
    const loadRooms = () => {
        fetch("fetchRooms.php")
            .then(response => response.json())
            .then(data => {
                const roomList = document.getElementById("room-list");
                roomList.innerHTML = ""; // Clear existing room list if any

                data.rooms.forEach(room => {
                    const roomDiv = document.createElement("div");
                    roomDiv.className = "room";
                    roomDiv.innerHTML = `
                        <h3>${room.name}</h3>
                        <p>${room.description}</p>
                        <p>Price per night: KES ${room.price_per_night}</p>
                        <button 
                            class="book-now" 
                            data-room-id="${room.id}" 
                            data-price="${room.price_per_night}" 
                            data-room-type="${room.name}">
                            Book Now
                        </button>
                    `;
                    roomList.appendChild(roomDiv);
                });
            })
            .catch(error => console.error("Error loading rooms:", error));
    };

    // Function to handle room booking and initiate payment
    const bookRoom = (roomId, price, roomType) => {
        // Ask for user phone number, check-in, and check-out dates
        const phone = prompt("Enter your phone number for payment:");
        const checkInDate = prompt("Enter your check-in date (YYYY-MM-DD):");
        const checkOutDate = prompt("Enter your check-out date (YYYY-MM-DD):");

        // Validate input data
        if (!phone || !checkInDate || !checkOutDate) {
            alert("Booking cancelled or invalid input.");
            return;
        }

        // Prepare booking details to be sent to the server
        const bookingDetails = {
            room_id: roomId,
            amount: Math.round(price),
            phone: phone,
            check_in_date: checkInDate,
            check_out_date: checkOutDate,
        };

        // Send data to backend to initiate payment and booking
        fetch("mpesaPayment.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(bookingDetails), // Send JSON data
        })
            .then(response => response.json()) // Parse the JSON response from PHP
            .then(data => {
                if (data.status === "Success") {
                    alert("Booking successful! Your Mpesa reference is: " + data.mpesa_reference);
                    // Optionally, redirect the user to a booking summary page
                } else {
                    alert("Payment failed: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("There was an error processing your payment.");
            });
    };

    // Load rooms when the page is ready
    if (document.getElementById("room-list")) {
        loadRooms();
    }

    // Add event listener for dynamically added "Book Now" buttons
    document.getElementById("room-list")?.addEventListener("click", function (e) {
        if (e.target && e.target.classList.contains("book-now")) {
            const roomId = e.target.getAttribute("data-room-id");
            const price = e.target.getAttribute("data-price");
            const roomType = e.target.getAttribute("data-room-type");

            // Trigger room booking
            bookRoom(roomId, price, roomType);
        }
    });
});
