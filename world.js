window.onload = function () {
    const lookupBtn = document.getElementById("lookup");
    const lookupCitiesBtn = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");

    lookupBtn.addEventListener("click", function () {
        let country = document.getElementById("country").value;
        let url = "world.php?country=" + encodeURIComponent(country);

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error("Error:", error);
                resultDiv.innerHTML = "An error occurred!";
            });
    });

    lookupCitiesBtn.addEventListener("click", function () {
        let country = document.getElementById("country").value;
        let url = "world.php?country=" + encodeURIComponent(country) + "&lookup=cities";

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error("Error:", error);
                resultDiv.innerHTML = "An error occurred!";
            });
    });
};
