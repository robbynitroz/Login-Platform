export const loginBackground = {

    data() {
        return {
            canvas: document.getElementById('stars'),
            particleCount: 40,
            flareCount: 10,
            motion: 0.05,
            tilt: 0.05,
            color: '#FFEED4',
            particleSizeBase: 1,
            particleSizeMultiplier: 0.5,
            flareSizeBase: 100,
            flareSizeMultiplier: 100,
            lineWidth: 1,
            linkChance: 75, // chance per frame of link, higher = smaller chance
            linkLengthMin: 5, // min linked vertices
            linkLengthMax: 7, // max linked vertices
            linkOpacity: 0.25, // number between 0 & 1
            linkFade: 90, // link fade-out frames
            linkSpeed: 1, // distance a link travels in 1 frame
            glareAngle: -60,
            glareOpacityMultiplier: 0.05,
            renderParticles: true,
            renderParticleGlare: true,
            renderFlares: true,
            renderLinks: true,
            renderMesh: false,
            flicker: true,
            flickerSmoothing: 15, // higher = smoother flicker
            blurSize: 0,
            orbitTilt: true,
            randomMotion: true,
            noiseLength: 1000,
            noiseStrength: 1,
            //context: document.getElementById('stars').getContext('2d'),
            mouse: {x: 0, y: 0},
            m: {},
            r: 0,
            c: 1000, // multiplier for delaunay points, since floats too small can mess up the algorithm
            n: 0,
            nAngle: (Math.PI * 2) / this.noiseLength,
            nRad: 100,
            nScale: 0.5,
            nPos: {x: 0, y: 0},
            points: [],
            vertices: [],
            triangles: [],
            links: [],
            particles: [],
            flares: [],
            //orbits: document.getElementById('orbits'),


        }
    },

    mounted() {
        this.next();
        this.init();

        },


    methods: {


        init() {
            var i, j, k;

            // requestAnimFrame polyfill
            window.requestAnimFrame = (function () {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    function (callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
            })();



            // Fade in background
            /*
            var background = document.getElementById('background'),
                bgImg = new Image(),
                bgURL = '/img/background.jpg';
            bgImg.onload = function() {
                //console.log('background loaded');
                background.style.backgroundImage = 'url("'+bgURL+'")';
                background.className += ' loaded';
            }
            bgImg.src = bgURL;
            */

            // Size canvas
            resize();

            this.mouse.x = this.canvas.clientWidth / 2;
            this.mouse.y = this.canvas.clientHeight / 2;

            // Create particle positions
            for (i = 0; i < this.particleCount; i++) {
                var p = new Particle();
                this.particles.push(p);
                this.points.push([p.x * c, p.y * c]);
            }

            //console.log(JSON.stringify(this.points));

            // Delaunay triangulation
            //var Delaunay = require('delaunay-fast');
            this.vertices = Delaunay.triangulate(this.points);
            //console.log(JSON.stringify(this.vertices));
            // Create an array of "triangles" (groups of 3 indices)
            var tri = [];
            for (i = 0; i < this.vertices.length; i++) {
                if (tri.length == 3) {
                    this.triangles.push(tri);
                    tri = [];
                }
                tri.push(this.vertices[i]);
            }
            //console.log(JSON.stringify(this.triangles));

            // Tell all the particles who their neighbors are
            for (i = 0; i < this.particles.length; i++) {
                // Loop through all tirangles
                for (j = 0; j < this.triangles.length; j++) {
                    // Check if this particle's index is in this triangle
                    k = this.triangles[j].indexOf(i);
                    // If it is, add its neighbors to the particles contacts list
                    if (k !== -1) {
                        this.triangles[j].forEach(function (value, index, array) {
                            if (value !== i && this.particles[i].neighbors.indexOf(value) == -1) {
                                this.particles[i].neighbors.push(value);
                            }
                        });
                    }
                }
            }
            //console.log(JSON.stringify(this.particles));

            if (this.renderFlares) {
                // Create flare positions
                for (i = 0; i < this.flareCount; i++) {
                    this.flares.push(new Flare());
                }
            }

            // Motion mode
            //if (Modernizr && Modernizr.deviceorientation) {
            if ('ontouchstart' in document.documentElement && window.DeviceOrientationEvent) {
                console.log('Using device orientation');
                window.addEventListener('deviceorientation', function (e) {
                    this.mouse.x = (this.canvas.clientWidth / 2) - ((e.gamma / 90) * (this.canvas.clientWidth / 2) * 2);
                    this.mouse.y = (this.canvas.clientHeight / 2) - ((e.beta / 90) * (this.canvas.clientHeight / 2) * 2);
                    //console.log('Center: x:'+(this.canvas.clientWidth/2)+' y:'+(this.canvas.clientHeight/2));
                    //console.log('Orientation: x:'+this.mouse.x+' ('+e.gamma+') y:'+mouse.y+' ('+e.beta+')');
                }, true);
            }
            else {
                // Mouse move listener
                console.log('Using mouse movement');
                document.body.addEventListener('mousemove', function (e) {
                    //console.log('moved');
                    this.mouse.x = e.clientX;
                    this.mouse.y = e.clientY;
                });
            }

            // Random motion
            if (this.randomMotion) {
                //var SimplexNoise = require('simplex-noise');
                //var simplex = new SimplexNoise();
            }

            // Animation loop
            (function animloop() {
                requestAnimFrame(animloop);
                resize();
                render();
            })();
        },

        render() {
            if (this.randomMotion) {
                n++;
                if (n >= this.noiseLength) {
                    n = 0;
                }

                this.nPos = this.noisePoint(n);
                //console.log('NOISE x:'+this.nPos.x+' y:'+this.nPos.y);
            }

            // Clear
            this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);

            if (this.blurSize > 0) {
                this.context.shadowBlur = this.blurSize;
                this.context.shadowColor = this.color;
            }

            if (this.renderParticles) {
                // Render particles
                for (var i = 0; i < this.particleCount; i++) {
                    this.particles[i].render();
                }
            }

            if (this.renderMesh) {
                // Render all lines
                this.context.beginPath();
                for (var v = 0; v < this.vertices.length - 1; v++) {
                    // Splits the array into triplets
                    if ((v + 1) % 3 === 0) {
                        continue;
                    }

                    var p1 = this.particles[this.vertices[v]],
                        p2 = this.particles[this.vertices[v + 1]];

                    //console.log('Line: '+p1.x+','+p1.y+'->'+p2.x+','+p2.y);

                    var pos1 = position(p1.x, p1.y, p1.z),
                        pos2 = position(p2.x, p2.y, p2.z);

                    this.context.moveTo(pos1.x, pos1.y);
                    this.context.lineTo(pos2.x, pos2.y);
                }
                this.context.strokeStyle = this.color;
                this.context.lineWidth = this.lineWidth;
                this.context.stroke();
                this.context.closePath();
            }

            if (this.renderLinks) {
                // Possibly start a new link
                if (random(0, this.linkChance) == this.linkChance) {
                    var length = random(this.linkLengthMin, this.linkLengthMax);
                    var start = random(0, this.particles.length - 1);
                    startLink(start, length);
                }

                // Render existing links
                // Iterate in reverse so that removing items doesn't affect the loop
                for (var l = this.links.length - 1; l >= 0; l--) {
                    if (this.links[l] && !this.links[l].finished) {
                        this.links[l].render();
                    }
                    else {
                        delete this.links[l];
                    }
                }
            }

            if (this.renderFlares) {
                // Render flares
                for (var j = 0; j < this.flareCount; j++) {
                    this.flares[j].render();
                }
            }

            /*
            if (this.orbitTilt) {
                var tiltX = -(((this.canvas.clientWidth / 2) - this.mouse.x + ((this.nPos.x - 0.5) * this.noiseStrength)) * tilt),
                    tiltY = (((this.canvas.clientHeight / 2) - this.mouse.y + ((this.nPos.y - 0.5) * this.noiseStrength)) * tilt);

                orbits.style.transform = 'rotateY('+tiltX+'deg) rotateX('+tiltY+'deg)';
            }
            */
        },

        resize() {
            this.canvas.width = window.innerWidth * (window.devicePixelRatio || 1);
            this.canvas.height = this.canvas.width * (this.canvas.clientHeight / this.canvas.clientWidth);
        },

        startLink(vertex, length) {
            //console.log('LINK from '+vertex+' (length '+length+')');
            this.links.push(new Link(vertex, length));
        },


// Particle class


        next() {

            var Particle = () => {
                this.x = random(-0.1, 1.1, true);
                this.y = random(-0.1, 1.1, true);
                this.z = random(0, 4);
                this.color = this.color;
                this.opacity = random(0.1, 1, true);
                this.flicker = 0;
                this.neighbors = []; // placeholder for neighbors
            };
            Particle.prototype.render = () => {
                var pos = position(this.x, this.y, this.z),
                    r = ((this.z * this.particleSizeMultiplier) + this.particleSizeBase) * (sizeRatio() / 1000),
                    o = this.opacity;

                if (flicker) {
                    var newVal = random(-0.5, 0.5, true);
                    this.flicker += (newVal - this.flicker) / this.flickerSmoothing;
                    if (this.flicker > 0.5) this.flicker = 0.5;
                    if (this.flicker < -0.5) this.flicker = -0.5;
                    o += this.flicker;
                    if (o > 1) o = 1;
                    if (o < 0) o = 0;
                }

                this.context.fillStyle = this.color;
                this.context.globalAlpha = o;
                this.context.beginPath();
                this.context.arc(pos.x, pos.y, r, 0, 2 * Math.PI, false);
                this.context.fill();
                this.context.closePath();

                if (this.renderParticleGlare) {
                    this.context.globalAlpha = o * this.glareOpacityMultiplier;
                    /*
                    this.context.ellipse(pos.x, pos.y, r * 30, r, 90 * (Math.PI / 180), 0, 2 * Math.PI, false);
                    this.context.fill();
                    this.context.closePath();
                    */
                    this.context.ellipse(pos.x, pos.y, r * 100, r, (this.glareAngle - ((this.nPos.x - 0.5) * this.noiseStrength * this.motion)) * (Math.PI / 180), 0, 2 * Math.PI, false);
                    this.context.fill();
                    this.context.closePath();
                }

                context.globalAlpha = 1;
            };

// Flare class
            var Flare = () => {
                this.x = random(-0.25, 1.25, true);
                this.y = random(-0.25, 1.25, true);
                this.z = random(0, 2);
                this.color = this.color;
                this.opacity = random(0.001, 0.01, true);
            };
            Flare.prototype.render = () => {
                var pos = position(this.x, this.y, this.z),
                    r = ((this.z * this.flareSizeMultiplier) + this.flareSizeBase) * (this.sizeRatio() / 1000);

                // Feathered circles
                /*
                var grad = this.context.createRadialGradient(x+r,y+r,0,x+r,y+r,r);
                grad.addColorStop(0, 'rgba(255,255,255,'+f.o+')');
                grad.addColorStop(0.8, 'rgba(255,255,255,'+f.o+')');
                grad.addColorStop(1, 'rgba(255,255,255,0)');
                this.context.fillStyle = grad;
                this.context.beginPath();
                this.context.fillRect(x, y, r*2, r*2);
               this.context.closePath();
                */

                this.context.beginPath();
                this.context.globalAlpha = this.opacity;
                this.context.arc(pos.x, pos.y, r, 0, 2 * Math.PI, false);
                this.context.fillStyle = this.color;
                this.context.fill();
                this.context.closePath();
                this.context.globalAlpha = 1;
            };

// Link class
            var Link = function (startVertex, numPoints) {
                this.length = numPoints;
                this.verts = [startVertex];
                this.stage = 0;
                this.linked = [startVertex];
                this.distances = [];
                this.traveled = 0;
                this.fade = 0;
                this.finished = false;
            };


            Link.prototype.render = () => {
                // Stages:
                // 0. Vertex collection
                // 1. Render line reaching from vertex to vertex
                // 2. Fade out
                // 3. Finished (delete me)

                var i, p, pos, points;

                switch (this.stage) {
                    // VERTEX COLLECTION STAGE
                    case 0:
                        // Grab the last member of the link
                        var last = this.particles[this.verts[this.verts.length - 1]];
                        //console.log(JSON.stringify(last));
                        if (last && last.neighbors && last.neighbors.length > 0) {
                            // Grab a random neighbor
                            var neighbor = last.neighbors[this.random(0, last.neighbors.length - 1)];
                            // If we haven't seen that particle before, add it to the link
                            if (this.verts.indexOf(neighbor) == -1) {
                                this.verts.push(neighbor);
                            }
                            // If we have seen that particle before, we'll just wait for the next frame
                        }
                        else {
                            //console.log(this.verts[0]+' prematurely moving to stage 3 (0)');
                            this.stage = 3;
                            this.finished = true;
                        }

                        if (this.verts.length >= this.length) {
                            // Calculate all distances at once
                            for (i = 0; i < this.verts.length - 1; i++) {
                                var p1 = this.particles[this.verts[i]],
                                    p2 = this.particles[this.verts[i + 1]],
                                    dx = p1.x - p2.x,
                                    dy = p1.y - p2.y,
                                    dist = Math.sqrt(dx * dx + dy * dy);

                                this.distances.push(dist);
                            }
                            //console.log('Distances: '+JSON.stringify(this.distances));
                            //console.log('verts: '+this.verts.length+' distances: '+this.distances.length);

                            //console.log(this.verts[0]+' moving to stage 1');
                            this.stage = 1;
                        }
                        break;

                    // RENDER LINE ANIMATION STAGE
                    case 1:
                        if (this.distances.length > 0) {

                            this.points = [];
                            //var a = 1;

                            // Gather all points already linked
                            for (i = 0; i < this.linked.length; i++) {
                                p = this.particles[this.linked[i]];
                                pos = position(p.x, p.y, p.z);
                                this.points.push([pos.x, pos.y]);
                            }

                            var linkSpeedRel = linkSpeed * 0.00001 * this.canvas.width;
                            this.traveled += linkSpeedRel;
                            var d = this.distances[this.linked.length - 1];
                            // Calculate last point based on linkSpeed and distance travelled to next point
                            if (this.traveled >= d) {
                                this.traveled = 0;
                                // We've reached the next point, add coordinates to array
                                //console.log(this.verts[0]+' reached vertex '+(this.linked.length+1)+' of '+this.verts.length);

                                this.linked.push(this.verts[this.linked.length]);
                                p = this.particles[this.linked[this.linked.length - 1]];
                                pos = position(p.x, p.y, p.z);
                                this.points.push([pos.x, pos.y]);

                                if (this.linked.length >= this.verts.length) {
                                    //console.log(this.verts[0]+' moving to stage 2 (1)');
                                    this.stage = 2;
                                }
                            }
                            else {
                                // We're still travelling to the next point, get coordinates at travel distance
                                // http://math.stackexchange.com/a/85582
                                var a = this.particles[this.linked[this.linked.length - 1]],
                                    b = this.particles[this.verts[this.linked.length]],
                                    t = d - this.traveled,
                                    x = ((this.traveled * b.x) + (t * a.x)) / d,
                                    y = ((this.traveled * b.y) + (t * a.y)) / d,
                                    z = ((this.traveled * b.z) + (t * a.z)) / d;

                                pos = position(x, y, z);

                                //console.log(this.verts[0]+' traveling to vertex '+(this.linked.length+1)+' of '+this.verts.length+' ('+this.traveled+' of '+this.distances[this.linked.length]+')');

                                this.points.push([pos.x, pos.y]);
                            }

                            this.drawLine(this.points);
                        }
                        else {
                            //console.log(this.verts[0]+' prematurely moving to stage 3 (1)');
                            this.stage = 3;
                            this.finished = true;
                        }
                        break;

                    // FADE OUT STAGE
                    case 2:
                        if (this.verts.length > 1) {
                            if (this.fade < this.linkFade) {
                                this.fade++;

                                // Render full link between all this.vertices and fade over time
                                this.points = [];
                                var alpha = (1 - (this.fade / this.linkFade)) * this.linkOpacity;
                                for (i = 0; i < this.verts.length; i++) {
                                    p = this.particles[this.verts[i]];
                                    pos = this.position(p.x, p.y, p.z);
                                    this.points.push([pos.x, pos.y]);
                                }
                                this.drawLine(this.points, alpha);
                            }
                            else {
                                //console.log(this.verts[0]+' moving to stage 3 (2a)');
                                this.stage = 3;
                                this.finished = true;
                            }
                        }
                        else {
                            //console.log(this.verts[0]+' prematurely moving to stage 3 (2b)');
                            this.stage = 3;
                            this.finished = true;
                        }
                        break;

                    // FINISHED STAGE
                    case 3:
                    default:
                        this.finished = true;
                        break;
                }
            };
            Link.prototype.drawLine = (points, alpha) => {
                if (typeof alpha !== 'number') alpha = this.linkOpacity;

                if (this.points.length > 1 && alpha > 0) {
                    //console.log(this.verts[0]+': Drawing line '+alpha);
                    this.context.globalAlpha = alpha;
                    this.context.beginPath();
                    for (var i = 0; i < this.points.length - 1; i++) {
                        this.context.moveTo(this.points[i][0], this.points[i][1]);
                        this.context.lineTo(this.points[i + 1][0], this.points[i + 1][1]);
                    }
                    this.context.strokeStyle = this.color;
                    this.context.lineWidth = this.lineWidth;
                    this.context.stroke();
                    this.context.closePath();
                    this.context.globalAlpha = 1;
                }
            };

        },
// Utils

        noisePoint(i) {
            var a = this.nAngle * i,
                cosA = Math.cos(a),
                sinA = Math.sin(a),
                //value = simplex.noise2D(this.nScale * cosA + this.nScale, this.nScale * sinA + this.nScale),
                //rad = this.nRad + value;
                rad = this.nRad;
            return {
                x: rad * cosA,
                y: rad * sinA
            };
        },

        position(x, y, z) {
            return {
                x: (x * this.canvas.width) + ((((this.canvas.width / 2) - this.mouse.x + ((this.nPos.x - 0.5) * this.noiseStrength)) * z) * this.motion),
                y: (y * this.canvas.height) + ((((this.canvas.height / 2) - this.mouse.y + ((this.nPos.y - 0.5) * this.noiseStrength)) * z) * this.motion)
            };
        },

        sizeRatio() {
            return this.canvas.width >= this.canvas.height ? this.canvas.width : this.canvas.height;
        },

        random(min, max, float) {
            return float ?
                Math.random() * (max - min) + min :
                Math.floor(Math.random() * (max - min + 1)) + min;
        },


    }
}