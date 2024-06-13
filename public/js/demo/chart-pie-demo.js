// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
    "'Nunito', '-apple-system, system-ui, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif'";
Chart.defaults.global.defaultFontColor = "#858796";

// Get data from the table
var clientStatusTable = document.getElementById("dataTable");
var clientStatusRows = clientStatusTable.getElementsByTagName("tr");
var clientStatusData = [];
for (var i = 1; i < clientStatusRows.length; i++) {
    // Start from index 1 to skip header row
    var cells = clientStatusRows[i].getElementsByTagName("td");
    var value = parseInt(cells[1].innerText);
    clientStatusData.push(value);
}

// Doughnut Chart Example
var ctx = document.getElementById("myPieChart").getContext("2d");
var myPieChart = new Chart(ctx, {
    type: "doughnut",
    data: {
        labels: ["Subscribed", "On hold", "Expired", "No subscription"],
        datasets: [
            {
                data: clientStatusData, // Use data from the table
                backgroundColor: [
                    "#4e73df", // Subscribe
                    "#f6c23e", // On hold
                    "#e74a3b", // Expired
                    "#858796", // No subscription
                ],
                hoverBackgroundColor: [
                    "#2e59d9", // Subscribe
                    "#dda20a", // On hold
                    "#c0392b", // Expired
                    "#6e707e", // No subscription
                ],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
        ],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true,
            position: "bottom", // Position legend at the bottom
        },
        cutoutPercentage: 80,
        title: {
            display: true,
            text:
                "Total Clients: " + clientStatusData.reduce((a, b) => a + b, 0), // Calculate and display the total number of clients
            fontColor: "#858796",
            position: "top", // Position title at the top
            fontSize: 16,
        },
    },
});
