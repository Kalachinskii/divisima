// нормальная цена
document.querySelectorAll(".discounted-Price")?.forEach((value) => {
    value.innerHTML = "$" + Number(value.innerHTML).toFixed(2);
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

// добавление картинки в БД / изменение если существует
document
    .getElementById("staticBackdrop")
    ?.querySelector(".modal-content")
    .addEventListener("change", function (e) {
        const file = e.target.files[0];

        if (file) {
            const formImg = new FormData();
            formImg.append("image", file);
            addImageDd(formImg, e.target);
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
                for (let i = 0; i < data[1].length - 1; i++) {
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
                                    <div class="row g-2 pb-1">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputGrid" placeholder="Сurrent price" value="${(
                                                data[0][0].price -
                                                (data[0][0].price / 100) *
                                                    data[0][0].discount
                                            ).toFixed(2)}" readonly>
                                            <label for="floatingInputGrid">Сurrent price</label>
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
                                        <div class="form-floating">
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
