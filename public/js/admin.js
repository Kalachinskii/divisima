const currentUrl = window.location.pathname;

if (currentUrl == "/admin/products") {
    const output = ` <ul class="nav btn-products-grup">
                <li class="nav-item d-grid col-12 mb-2 mt-2 mx-auto">
                <button type="button" class="btn btn-secondary btn-sm btn-add-product" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fa-solid fa-cart-plus"></i>
                    <span>&ensp;Add Product</span>
                </button>
                </li>
                <li class="nav-item d-grid col-12 mx-auto">
                    <form class="d-flex" id="add-category-form">
                        <input class="form-control-sm form-control me-2" type="search" placeholder="Add category" name="categorie">
                        <button class="btn btn-secondary btn-sm" type="submit">Add</button>
                    </form>
                </li>
                <li class="nav-item d-grid col-12 mx-auto mt-2">
                    <form class="d-flex" id="del-category-form">
                        <select class="form-select form-select-sm me-2" id="select-all-category" name="category">
                            <option selected value="null">Null</option>
                        </select>
                        <button class="btn btn-secondary btn-sm" type="submit">Delete</button>
                    </form>
                </li>
            </ul>`;
    document.getElementById("products-nav-item").classList.add("activ-btn");
    document
        .getElementById("products-nav-item")
        .insertAdjacentHTML("beforeend", output);
    alertElem =
        document.getElementById("products-nav-item").previousElementSibling;

    getAllCategory(alertElem);
} else if (currentUrl == "/admin/users") {
    document.getElementById("users-nav-item").classList.add("activ-btn");
}

function getAllCategory(alertElem) {
    fetch("getAllCategory")
        .then((resp) => {
            if (!resp.ok) {
                throw new Error(
                    "Ошибка добавления визбранное. Попробуйте позже"
                );
            }
            return resp.json();
        })
        .then((data) => {
            if (data === false) {
                throw new Error(
                    "Ошибка добавления в корзину. Попробуйте позже"
                );
            } else {
                let options = ``;
                for (let i = 0; i < Object.keys(data).length; i++) {
                    options += `<option value='${data[i].id}'>${data[i].name}</option>`;
                }

                alertElem
                    .closest("ul")
                    .querySelector("select")
                    .insertAdjacentHTML("beforeend", options);
            }
        })
        .catch((err) => {
            if (PROD) {
                alert(err);
            } else {
                console.error(err);
            }
        });
}
