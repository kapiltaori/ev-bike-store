function formatPrice(price) {
  //   return parseInt(price).toLocaleString();
  const priceString = parseInt(price).toString(); // Remove decimals and convert to string
  let lastThreeDigits = priceString.slice(-3);
  let otherDigits = priceString.slice(0, -3);

  if (otherDigits !== "") {
    lastThreeDigits = "," + lastThreeDigits;
  }

  const formattedPrice =
    otherDigits.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThreeDigits;
  return formattedPrice;
}
