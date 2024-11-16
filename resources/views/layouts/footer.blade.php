        <footer class="main-footer">
            <strong id="date-footer"></strong>
        </footer>
        <script>
            // Function to format the current date in the desired format
            function formatDate() {
                const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                    "October", "November", "December"
                ];

                const currentDate = new Date();
                const dayOfWeek = daysOfWeek[currentDate.getDay()];
                const day = currentDate.getDate();
                const month = months[currentDate.getMonth()];
                const year = currentDate.getFullYear();

                // Format the date
                return `${dayOfWeek}, ${day} ${month} ${year}`;
            }

            // Insert the formatted date into the footer
            document.getElementById("date-footer").innerText = formatDate();
        </script>
