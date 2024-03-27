alert("SELAMAT MENUNAIKAN IBADAH PUASA WAHAI HAMBA SETIA!");

var texts = [
  "Hello World!",
  "Semangat Puasanya",
  "Jangan Mokel",
  "Jaga Kesehatan!",
];
var currentIndex = 0;

document.getElementById("myButton").addEventListener("click", function () {
  document.getElementById("myH1").innerText = texts[currentIndex];
  currentIndex = (currentIndex + 1) % texts.length;
});

let orang = ["Alpha", "Beta", "Charlie", "Delta"];
document.write("<p>Sebelum ditambah: " + orang.join(", ") + "</p>");
console.log(orang);

orang[4] = "Etha";
orang[5] = "Foxfort";
console.log(orang);
document.write("<p>Setelah ditambah: " + orang.join(", ") + "</p>");
