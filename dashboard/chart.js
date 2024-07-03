
const ctx = document.getElementById('linechart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['', '', '', '', '', ''],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});



// fetch('data.php')
// .then(response => response.json())
// .then(data => {
//     // Access the canvas element
//     var ctx = document.getElementById('linechart').getContext('2d');

//     // Create a new Chart instance
//     var myChart1 = new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: data.labels,
//             datasets: [{
//                 label: 'Monthly Sales',
//                 data: data.data,
//                 backgroundColor: 'rgba(54, 162, 235, 0.2)',
//                 borderColor: 'rgba(54, 162, 235, 1)',
//                 borderWidth: 1
//             }]
//         },
//         options: {
//             scales: {
//                 y: {
//                     beginAtZero: true
//                 }
//             }
//         }
//     });
// })
// .catch(error => {
//     console.error('Error fetching data:', error);
// });
