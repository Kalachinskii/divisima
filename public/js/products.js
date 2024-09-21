// нормальная цена
document.querySelectorAll(".discounted-Price")?.forEach((value) => {
    value.innerHTML = "$" + Number(value.innerHTML).toFixed(2);
});

document.querySelector("aside").addEventListener("click", (e) => {
    if (e.target.matches("#add-category-form [type='submit']")) {
        e.preventDefault();
        const data = new FormData(e.target.closest("form"));
        const category = Object.fromEntries(data);
        const body = JSON.stringify({ category });
        addNewCategory(body);
    } else if (e.target.matches("#del-category-form [type='submit']")) {
        e.preventDefault();
        const id = e.target.closest("form").querySelector("select").value;
        deleteCategory(id);
    }
});

document.querySelector(".table-striped")?.addEventListener("click", (e) => {
    const productId = e.target.closest("tr").dataset.id;
    const body = JSON.stringify({ productId });

    if (e.target.matches(".fa-pen-to-square, .fa-pen-to-square *")) {
        getTargetProduct(body);
    } else if (e.target.matches(".delete-btn, .delete-btn *")) {
        deleteProduct(body);
    }
});

// Добавить новый продукт в БД
document.getElementById("addProductModal")?.addEventListener("click", (e) => {
    if (e.target.matches(".btn-add-new-product")) {
        e.preventDefault();
        let formContent = new FormData(e.target.closest("form"));

        if (
            e.target.closest("form").querySelector(".form-add-img").files[0]
                ?.name
        ) {
            formContent.append(
                "imageName",
                e.target.closest("form").querySelector(".form-add-img")
                    ?.files[0].name
            );
        } else {
            form = e.target
                .closest(".modul-box")
                .querySelector("img")
                ?.src.split("/");
            formContent.append("imageName", form[form.length - 1]);
        }
        formContent = Object.fromEntries(formContent);
        body = JSON.stringify({ formContent });

        addNewProduct(body);
    }
});

// Добавить картинку на сервер в модуле addProduct
document
    .getElementById("addProductModal")
    ?.querySelector(".modal-content")
    .addEventListener("change", function (e) {
        if (e.target.matches("[type='file']")) {
            const file = e.target.files[0];

            if (file) {
                const formImg = new FormData();
                formImg.append("image", file);
                addImageDd(formImg, e.target);
            }
        }
    });

// изменить картинку в addProduct
document.getElementById("addProductModal")?.addEventListener("change", (e) => {
    if (e.target.matches("[type='file']")) {
        let imgStr = e.target.value;
        imgArr = imgStr.split("\\");
        imgName = imgArr[imgArr.length - 1];

        document
            .getElementById("addProductModal")
            .querySelector(".img-box")
            .querySelector("img").src = `/public/img/product/${imgName}`;
    }
});

// добавление картинки в БД / изменение если существует
document
    .getElementById("staticBackdrop")
    ?.querySelector(".modal-content")
    .addEventListener("change", function (e) {
        if (e.target.matches("[type='file']")) {
            const file = e.target.files[0];

            if (file) {
                const formImg = new FormData();
                formImg.append("image", file);
                addImageDd(formImg, e.target);
            }
        }
    });

function addImageDd(formData, elem) {
    fetch("addImageDd", {
        method: "POST",
        headers: {
            credentials: "same-origin",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: formData,
    })
        .then((resp) => {
            if (!resp.ok) {
                throw new Error(
                    "Ошибка добавления визбранное. Попробуйте позже"
                );
            }
            return resp.text();
        })
        .then((data) => {
            if (data === false) {
                throw new Error(
                    "Ошибка добавления в корзину. Попробуйте позже"
                );
            } else {
                elem
                    .closest(".modul-box")
                    .querySelector("img").src = `/public/img/product/${data}`;
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

document
    .getElementById("staticBackdrop")
    ?.querySelector(".modal-content")
    .addEventListener("change", (e) => {
        if (e.target.matches("[type='file']")) {
            let imgStr = e.target.value;
            imgArr = imgStr.split("\\");
            imgName = imgArr[imgArr.length - 1];

            document
                .getElementById("staticBackdrop")
                .querySelector(".img-box")
                .querySelector("img").src = `/public/img/product/${imgName}`;
        }
    });

// изменение данных по продукту в БД
document
    .getElementById("staticBackdrop")
    ?.querySelector(".modal-content")
    .addEventListener("click", function (e) {
        if (e.target.matches(".btn-change")) {
            e.preventDefault();
            const idProducts = e.target.closest("form").dataset.id;
            let formContent = new FormData(e.target.closest("form"));

            if (
                e.target.closest("form").querySelector(".form-add-img").files[0]
                    ?.name
            ) {
                formContent.append(
                    "imageName",
                    e.target.closest("form").querySelector(".form-add-img")
                        ?.files[0].name
                );
            } else {
                form = e.target
                    .closest(".modul-box")
                    .querySelector("img")
                    ?.src.split("/");
                formContent.append("imageName", form[form.length - 1]);
            }
            formContent.append("idProducts", idProducts);
            formContent = Object.fromEntries(formContent);
            // console.log(formContent);

            body = JSON.stringify({ formContent, idProducts });

            changeProduct(body);
        }
    });

function getTargetProduct(body) {
    fetch("getTargetProduct", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            credentials: "same-origin",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: body,
    })
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
                for (let i = 0; i < data[1].length; i++) {
                    options += `<option value="${data[1][i].id}">${data[1][i].name}</option>`;
                }

                document
                    .getElementById("staticBackdrop")
                    .querySelector(".modal-content").innerHTML = "";

                const output = `
                    <div class="row g-0 modul-box">
                        <div class="col-md-4 img-box">
                            <img src="/public/img/product/${
                                data[0][0].image
                            }" class="img-fluid rounded-start" style="width:100%; height:100%;">
                        </div>
                        <form class="col-md-8" data-id="${
                            JSON.parse(body).productId
                        }" enctype="multipart/form-data">
                            <div class="card-body ">
                                <div class="modal-body">
                                    <div class="row g-2 pb-1">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputGrid" name="name" placeholder="Name product" value="${
                                                data[0][0].name
                                            }">
                                            <label for="floatingInputGrid">Name product</label>
                                        </div>
                                    </div>
                                    <div class="row g-2 pb-1">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputGrid" name="price" placeholder="Price" value="${
                                                data[0][0].price
                                            }">
                                            <label for="floatingInputGrid">Price</label>
                                        </div>
                                    </div>
                                    <div class="row g-2 pb-1">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputGrid" name="discount" placeholder="Discount" value="${
                                                data[0][0].discount || 0
                                            }">
                                            <label for="floatingInputGrid">Discount</label>
                                        </div>
                                    </div>
                                    <div class="row g-2 add-file-img mt-1">
                                        <div class="mb-3">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="1" placeholder="Describe the product" name="textarea">${
                                                data[0][0].description
                                            }</textarea>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputGrid" name="count" placeholder="Count" value="${
                                                data[0][0].count
                                            }">
                                            <label for="floatingInputGrid">Count</label>
                                        </div>
                                    </div>
                                    <div class="row g-2 add-file-img">
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">New image</label>
                                            <input class="form-control form-add-img" type="file" id="formFile" accept="image/png, image/jpeg">
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="form-floating col">
                                            <select class="form-select" id="floatingSelectGrid" name="category" aria-label="Floating label select example">
                                                <option selected value="${
                                                    data[2]
                                                }">
                                                    ${data[0][0].category_name}
                                                </option>
                                                ${options}
                                            </select>
                                            <label for="floatingSelectGrid">Categories</label>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="0" name="hot" id="flexRadioDefault1" checked>
                                                <label class="form-check-label" for="flexRadioDefault1"> Ordinary product </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="1" name="hot" id="flexRadioDefault2">
                                                <label class="form-check-label" for="flexRadioDefault2"> Hot product</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary btn-change">Change</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                `;
                document
                    .getElementById("staticBackdrop")
                    .querySelector(".modal-content")
                    .insertAdjacentHTML("beforeend", output);
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

function changeProduct(body) {
    fetch("changeProduct", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            credentials: "same-origin",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: body,
    })
        .then((resp) => {
            if (!resp.ok) {
                throw new Error(
                    "Ошибка добавления визбранное. Попробуйте позже"
                );
            }
            return resp.text();
        })
        .then((data) => {
            if (data === false) {
                throw new Error(
                    "Ошибка добавления в корзину. Попробуйте позже"
                );
            } else {
                // console.log(data);
                location.reload();
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

function addNewCategory(body) {
    fetch("addNewCategory", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            credentials: "same-origin",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: body,
    })
        .then((resp) => {
            if (!resp.ok) {
                throw new Error(
                    "Ошибка добавления визбранное. Попробуйте позже"
                );
            }
            return resp.text();
        })
        .then((data) => {
            if (data === false) {
                throw new Error(
                    "Ошибка добавления в корзину. Попробуйте позже"
                );
            } else {
                location.reload();
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

function addNewProduct(body) {
    fetch("addNewProduct", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            credentials: "same-origin",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: body,
    })
        .then((resp) => {
            if (!resp.ok) {
                throw new Error(
                    "Ошибка добавления визбранное. Попробуйте позже"
                );
            }
            return resp.text();
        })
        .then((data) => {
            if (data === false) {
                throw new Error(
                    "Ошибка добавления в корзину. Попробуйте позже"
                );
            } else {
                // console.log(data);
                location.reload();
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

function deleteProduct(body) {
    fetch("deleteProduct", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            credentials: "same-origin",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: body,
    })
        .then((resp) => {
            if (!resp.ok) {
                throw new Error(
                    "Ошибка добавления визбранное. Попробуйте позже"
                );
            }
            return resp.text();
        })
        .then((data) => {
            if (data === false) {
                throw new Error(
                    "Ошибка добавления в корзину. Попробуйте позже"
                );
            } else {
                location.reload();
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

function deleteCategory(id) {
    fetch("deleteCategory", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            credentials: "same-origin",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: id,
    })
        .then((resp) => {
            if (!resp.ok) {
                throw new Error(
                    "Ошибка добавления визбранное. Попробуйте позже"
                );
            }
            return resp.text();
        })
        .then((data) => {
            if (data === false) {
                throw new Error(
                    "Ошибка добавления в корзину. Попробуйте позже"
                );
            } else {
                location.reload();
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

// скидка при добавлении товара непривышает 100
document.getElementById("addProductModal")?.addEventListener("input", (e) => {
    if (e.target.matches(".input-discount")) {
        if (e.target.value.length > 0 && e.target.value <= 100) {
            e.target.value = e.target.value.replace(/\D/g, "").substr(0, 3);
        } else if (e.target.value > 100) {
            e.target.value = 100;
        } else {
            e.target.value = 0;
        }
    } else if (e.target.matches(".input-price")) {
        if (e.target.value > 99999.99) {
            e.target.value = 99999.99;
        }
    }
});
