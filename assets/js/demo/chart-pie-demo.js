// Ambil data dari elemen HTML tersembunyi
var dataGrafikPie = JSON.parse(
  document.getElementById("dataGrafik").textContent
);

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
  "Nunito, -apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif";
Chart.defaults.global.defaultFontColor = "#858796";

// Generate dynamic colors
var dynamicColors = function (numColors) {
  var colors = [];
  for (var i = 0; i < numColors; i++) {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    colors.push("rgb(" + r + "," + g + "," + b + ")");
  }
  return colors;
};

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: "doughnut",
  data: {
    labels: dataGrafikPie.map(function (data) {
      return data.category;
    }),
    datasets: [
      {
        data: dataGrafikPie.map(function (data) {
          return data.total;
        }),
        backgroundColor: dynamicColors(dataGrafikPie.length),
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
      display: false,
    },
    cutoutPercentage: 80,
  },
});

// Set colors for legend items
var legendItems = document.querySelectorAll(".text-center span");
var chartColors = myPieChart.data.datasets[0].backgroundColor;

legendItems.forEach(function (item, index) {
  item.querySelector("i").style.color = chartColors[index];
});
