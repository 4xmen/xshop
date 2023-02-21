try {
    var ctx = document.getElementById("canvas").getContext('2d');


    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse(document.querySelector('#labels').value),
            datasets: [{
                label: 'قیمت محصول', // Name the series
                data: JSON.parse(document.querySelector('#prices').value), // Specify the data values array
                fill: false,
                borderColor: '#2196f3', // Add custom color border (Line)
                backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
                borderWidth: 1 // Specify bar border width
            }]},
        options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
        }
    });
} catch(e) {
    console.log(e.message);
}
