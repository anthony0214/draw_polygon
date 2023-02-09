
<canvas id="canvas"></canvas>
    <div id="coords"></div>
    <button id="reset-btn">Reset</button>
<script>
  const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");
let dots = [];
let img = new Image();
img.src = "image/Ground-truth image.jpeg";
img.onload = function () {
  canvas.width = img.width;
  canvas.height = img.height;
  ctx.drawImage(img, 0, 0);
};

let isPolygonClosed = false;

canvas.addEventListener("click", (event) => {
  if (isPolygonClosed) return;

  const rect = canvas.getBoundingClientRect();
  const x = event.clientX - rect.left;
  const y = event.clientY - rect.top;

  dots.push({ x, y });
  draw();
});

function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.drawImage(img, 0, 0);
  for (let i = 0; i < dots.length; i++) {
    ctx.fillRect(dots[i].x, dots[i].y, 5, 5);
    if (i > 0) {
      ctx.beginPath();
      ctx.moveTo(dots[i - 1].x + 2.5, dots[i - 1].y + 2.5);
      ctx.lineTo(dots[i].x + 2.5, dots[i].y + 2.5);
      ctx.stroke();
    }
  }
  if (dots.length > 2) {
    const threshold = 20;
    const distance = Math.sqrt(
      Math.pow(dots[0].x - dots[dots.length - 1].x, 2) +
        Math.pow(dots[0].y - dots[dots.length - 1].y, 2)
    );
    if (distance < threshold) {
      ctx.beginPath();
      ctx.moveTo(dots[0].x + 2.5, dots[0].y + 2.5);
      ctx.lineTo(dots[dots.length - 1].x + 2.5, dots[dots.length - 1].y + 2.5);
      ctx.stroke();
      dots[dots.length - 1] = dots[0];
      isPolygonClosed = true;
      //alert("Polygon is closed. Coordinates: " + JSON.stringify(dots));
      //alert("Polygon is closed. Coordinates: " + '(' + dots.map(dot => `(${dot.x}, ${dot.y})`).join(', ') + ')');
      alert("Polygon is closed. Coordinates: " + '[' + dots.map(dot => `(${dot.x}, ${dot.y})`).join(', ') + ']');
      document.getElementById("coords").innerHTML = '[' + dots.map(dot => `(${dot.x}, ${dot.y})`).join(', ') + ']';

      console.log(JSON.stringify(dots))
    }
  }
}

const resetBtn = document.getElementById("reset-btn");
resetBtn.addEventListener("click", () => {
  dots = [];
  isPolygonClosed = false;
  draw();
});



  </script>