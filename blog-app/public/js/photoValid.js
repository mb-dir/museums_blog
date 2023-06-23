document.addEventListener("DOMContentLoaded", function() {
  const photoInput = document.querySelector("#photo");
  photoInput.addEventListener("change", () => {
    const file = photoInput.files[0];
    const maxSizeInBytes = 300 * 1024; // 300 kB
    if (file.size > maxSizeInBytes) {
      alert("Wybrany obrazek jest zbyt duży. Maksymalny rozmiar to 300 kB.");
      photoInput.value = "";
    }
  });
});
