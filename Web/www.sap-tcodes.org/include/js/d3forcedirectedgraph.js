/* global d3, self */

// Example from - http://bl.ocks.org/mbostock/4062045

function drawForceDirectedGraph(datasource, width) {
    var chartWidth = width;
    var chartHeight = chartWidth * 0.618;
    
    var svg = d3.select(".d3chartarea_main").append("svg")
            .attr("width", chartWidth)
            .attr("height", chartHeight);

    var force = d3.layout.force()
            .gravity(0.05)
            .distance(100)
            .charge(-100)
            .size([chartWidth, chartHeight]);

    d3.json(datasource, function (error, json) {
        if (error)
            throw error;

        force
                .nodes(json.nodes)
                .links(json.links)
                .start();

        var link = svg.selectAll(".link")
                .data(json.links)
                .enter().append("line")
                .attr("class", "link");

        var node = svg.selectAll(".node")
                .data(json.nodes)
                .enter().append("g")
                .attr("class", "node")
                .call(force.drag);

        node.append("image")
                .attr("xlink:href", function (d) {
                    return d.icon_url;
                })
                .attr("x", -8)
                .attr("y", -8)
                .attr("width", 16)
                .attr("height", 16)
                .on("dblclick", function (d) {
                    console.log(d.url);
                    if (d.newwin == 'Yes') {
                        var win = window.open(d.url, '_blank');
                        win.focus();
                    } else {
                        window.open(d.url);
                    }
                });

        node.append("title")
                .text(function (d) {
                    return d.title + '\nDouble Click to Open';
                });

        node.append("text")
                .attr("dx", 12)
                .attr("dy", ".35em")
                .text(function (d) {
                    return d.name
                });

        force.on("tick", function () {
            link.attr("x1", function (d) {
                return d.source.x;
            }).attr("y1", function (d) {
                return d.source.y;
            }).attr("x2", function (d) {
                return d.target.x;
            }).attr("y2", function (d) {
                return d.target.y;
            });

            node.attr("transform", function (d) {
                return "translate(" + d.x + "," + d.y + ")";
            });
        });
    });
}