const dynamicTexts = ["Future Programmer", "Web Developer", "Android developer"];
  let textIndex = 0;

  function type() {
    const typingElement = document.getElementById("typing-text");
    typingElement.innerHTML = "";
    const currentText = dynamicTexts[textIndex];
    let charIndex = 0;

    function typeCharacter() {
      if (charIndex < currentText.length) {
        typingElement.innerHTML += currentText.charAt(charIndex);
        charIndex++;
        setTimeout(typeCharacter, 100); // Adjust the typing speed (in milliseconds)
      } else {
        setTimeout(deleteCharacter, 3000); // Pause before deleting the text (in milliseconds)
      }
    }

    function deleteCharacter() {
      if (typingElement.innerHTML.length > 0) {
        typingElement.innerHTML = typingElement.innerHTML.slice(0, -1);
        setTimeout(deleteCharacter, 50); // Adjust the deletion speed (in milliseconds)
      } else {
        textIndex = (textIndex + 1) % dynamicTexts.length;
        setTimeout(type, 500); // Pause before typing the next sentence (in milliseconds)
      }
    }

    typeCharacter();
  }

  document.addEventListener("DOMContentLoaded", function () {
    setTimeout(type, 1000); // Start the typing animation after 1 second
  });
  
  