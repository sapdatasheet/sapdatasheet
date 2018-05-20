/* global d3, self */

// Example from - http://bl.ocks.org/mbostock/4063269

/**
 * Draw the bubble chart.
 * 
 * @param {string} datasource The PHP file generating the JSON data source
 * @param {number} size The Size of the chart area
 */
function drawBubbleChart(datasource, size) {

    var diameter = size;
    var color = d3.scale.category20c();

    var bubble = d3.layout.pack()
            .sort(null)
            .size([diameter, diameter])
            .padding(1.5);

    // The chart will be inside the div: <div class="d3chartarea_main">
    var svg = d3.select(".d3chartarea_main").append("svg")
            .attr("width", diameter)
            .attr("height", diameter)
            .attr("class", "bubble");

    d3.json(datasource, function (error, root) {
        if (error) {
            throw error;
        }

        var node = svg.selectAll(".node")
                .data(bubble.nodes(classes(root))
                        .filter(function (d) {
                            return !d.children;
                        }))
                .enter().append("g")
                .attr("class", "node")
                .attr("transform", function (d) {
                    return "translate(" + d.x + "," + d.y + ")";
                });

        node.append("title")
                .text(function (d) {
                    return d.title;
                });

        node.append("circle")
                .attr("r", function (d) {
                    return d.r;
                })
                .style("fill", function (d) {
                    return color(d.className);
                })
                .on("click", function (d) {
                    click_me(d.url);
                });

        node.append("text")
                .attr("dy", ".3em")
                .style("text-anchor", "middle")
                .text(function (d) {
                    return d.className.substring(0, d.r / 3);
                })
                .on("click", function (d) {
                    click_me(d.url);
                });

    });

    d3.select(self.frameElement).style("height", diameter + "px");
}

// Returns a flattened hierarchy containing all leaf nodes under the root.
function classes(root) {
    var classes = [];

    function recurse(name, node) {
        if (node.children)
            node.children.forEach(function (child) {
                recurse(node.label, child);
            });
        else
            classes.push({packageName: name, className: node.label, value: node.value, url: node.url, title: node.caption});
    }

    recurse(null, root);
    return {children: classes};
}

/**
 * Open the URL in a new tab/window.
 * 
 * @param {string} url URL to be open in new tab/window
 */
function click_me(url) {
    var win = window.open(url, '_blank');
    win.focus();
}
