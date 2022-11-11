
var ctx = document.getElementById('chart').getContext('2d');
ctx.canvas.width = 1000;
ctx.canvas.height = 250;

let barData = window.chart_data.data;

console.dir(barData);

var chart = new Chart(ctx, {
    type: 'candlestick',
    data: {
        datasets: [{
            label: window.chart_data.title,
            data: barData
        }]
    }
});


var update = function () {
    var dataset = chart.config.data.datasets[0];



    dataset.color = {
        up: '#01ff01',
        down: '#fe0000',
        unchanged: '#999',
    };


    // border
    var border = document.getElementById('border').value;
    var defaultOpts = Chart.defaults.elements[type];
    if (border === 'true') {
        dataset.borderColor = defaultOpts.borderColor;
    } else {
        dataset.borderColor = {
            up: defaultOpts.color.up,
            down: defaultOpts.color.down,
            unchanged: defaultOpts.color.up
        };
    }

    // mixed charts
    var mixed = document.getElementById('mixed').value;
    if (mixed === 'true') {
        chart.config.data.datasets = [
            {
                label: window.chart_data.title,
                data: barData ?? []
            },
            {
                label: 'Close price',
                type: 'line',
                data: barData ?? []
            }
        ]
    }
    else {
        chart.config.data.datasets = [
            {
                label: window.chart_data.title,
                data: barData ?? []
            }
        ]
    }

    chart.update();
};
