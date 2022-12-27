window.onload = () =>{
    const FiltersForm = document.querySelector('#filters');

    document.querySelectorAll("#filters input").forEach(input =>{
        input.addEventListener("change", () =>{

            const Form = new FormData(FiltersForm);

            const Params = new URLSearchParams();

            Form.forEach((value, key) => {
                Params.append(key, value);
            })

            const Url = new URL(window.location.href)
            // console.log(Url)

            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response =>
                    response.json()
            ).then(data => {
                const content = document.querySelector("#content");
                content.innerHTML = data.content
                // console.log(data.content)
            }).catch(e =>alert(e))
        })
    })
}