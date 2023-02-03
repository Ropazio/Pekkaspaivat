const x_akseli = [];
var y_akseli = [];
const keskiyo = new Date("July 21, 1983 01:15:00");

var data = [{
    x: x_akseli,
    y: y_akseli,
    type: "bar"  }];

var layout = {
    xaxis: {
        type: 'date',
        tickformat: '%H:%M',
        tickcolor: '#000',
        tick0: const d = new Date("July 21, 1983 01:15:00");
        dtick: 86400000.0 / 24 / 60 * 15 // Every 15min counted from ms per day
    }
}

var otsikko = {title:"Pörriäishavaintojen saapumis- ja lähtemisajat suhteutettuna havaintojen lukumäärään."};

Plotly.newPlot("kuvaaja", data, otsikko);