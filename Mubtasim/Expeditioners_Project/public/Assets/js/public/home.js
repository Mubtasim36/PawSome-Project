document.addEventListener("DOMContentLoaded", function () {
  const filter = document.getElementById("statusFilter");
  const cards = document.querySelectorAll(".Browse_Cards > div"); //Selecting All pet cards

  filter.addEventListener("change", function () {
    //to check if dropdown option selection is changed
    const selected = filter.value; //getting selected value

    cards.forEach((card) => {
      const statusText = card
        .querySelector(".Status li") //.Status is the class of the availibility text and li is the element
        .textContent.toLowerCase();

      if (selected === "all" || statusText === selected) {
        card.style.display = "block"; //Show the card
      } else {
        card.style.display = "none"; //Hide the card
      }
    });
  });
});
