window.onload = () =>{
    const FiltersForm = document.querySelector('#filters');

    document.querySelectorAll("#filters input").forEach(input =>{
        input.addEventListener("change", () =>{

            const Form = new FormData(FiltersForm);

            const Param = new URLSearchParams();

            Form.forEach((value, key) => {
                Param.append(key, value);
                console.log(Param.toString())
            })

            const Url = new URL(window.location.href)
            console.log(Url)

            fetch(Url.pathname + "?" + Param.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response => {
                console.log(response)
                }
            ).then(data => {
                console.log(data)
            }).catch(e =>alert(e))
        })
    })
}