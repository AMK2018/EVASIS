
var updateTable = function (path, table, loader, type, userType, idUser) {

    var users = Array();
    var tbody = table + " tbody";

    $(table).hide();
    $(loader).show();

    $.get(path, function (data) {
        if (data.today != undefined) {
            $(".lbldate").text("Evaluaciones " + data.today);
        }
        if (data.stuff.length > 0) {
            if (data.success == true || data.success.includes("true")) {
                for (var i = 0; i < data.stuff.length; i++) {
                    users[i] = data.stuff[i];
                }
            } else {
                alert("falla al cargar datos intenta de nuevo mas tarde...");
            }
        }
    }, 'json').done(function () {
        $(loader).hide();
        $(table).show();
    }).fail(function (xhr, status, error) {
        alert("Error intenta de nuevo...");
    }).always(function () {
        $(tbody).empty();
        for (var i = 0; i < users.length; i++) {
            switch (type) {
                case 1:
                    //USERS
                    var actions = null;

                    switch (userType) {
                        case "Administrador":
                            actions = '<tr><td>' + users[i].id + '</td><td><a id="go2profile-' + users[i].id + '-' + i + '" style="cursor:pointer;">' + users[i].name + '</a></td><td>' + users[i].fecha + '</td><td>' + users[i].tipo + '</td><td class="actions"><ul class="icons"><li><a id="asign-' + users[i].id + '-' + i + '" href="#gestionAsign" class="icon fa-tag"><span class="label">Asignar</span></a></li><li><a id="edit-' + users[i].id + '-' + i + '" href="#gestion" class="icon fa-pencil"><span class="label">Editar</span></a></li><li><a id="del-' + users[i].id + '-' + i + '" href="#gestion" class="icon fa-trash-o"><span class="label">Eliminar</span></a></li></ul></td></tr>';
                            break;
                        case "Especialista":

                            $("#usuarios .container .actions").remove();

                            actions = '<tr><td>' + users[i].id + '</td><td><a id="go2profile-' + users[i].id + '-' + i + '" style="cursor:pointer;">' + users[i].name + '</a></td><td>' + users[i].fecha + '</td><td>' + users[i].tipo + '</td><td class="actions"><ul class="icons"><li><a id="asign-' + users[i].id + '-' + i + '" href="#gestionAsign" class="icon fa-tag"><span class="label">Asignar</span></a></li><li><a id="unasign-' + users[i].id + '-' + i + '" href="#gestionAsign" class="icon fa-minus"><span class="label">Elminiar</span></a></li></ul></td></tr>';
                            break;
                    }

                    $(tbody).append(actions);

                    $(tbody).on('click', '#go2profile-' + users[i].id + '-' + i, function () {
                        var id = $(this).attr('id');
                        var split = id.split('-');
                        var info = users[split[2]];
                        var json = JSON.stringify(info);
                        openPopupPage("../profile/index.php", json);
                    });

                    $(tbody).on('click', '#asign-' + users[i].id + '-' + i, function () {
                        var id = $(this).attr('id');

                        var split = id.split('-');
                        var info = users[split[2]];

                        $("#gestionAsign .modal-content header h2").text("Asignar Evaluación");
                        $("#gestionAsign .modal-content form button").text("Asignar");

                        $(".txtiduser").val(info.id);
                    });

                    var closasign = $('#asign-' + users[i].id + '-' + i).animatedModal({
                        modalTarget: 'gestionAsign',
                        animatedIn: 'slideInUp',
                        animatedOut: 'slideOutDown',
                        color: '#f5fafa',
                        beforeOpen: function () {
                            $("#gestionAsign").css("display", "block");
                        },
                        afterOpen: function () {
                            console.log("The animation is completed");
                        },
                        beforeClose: function () {
                            console.log("The animation was called");
                        },
                        afterClose: function () {
                            $("#gestionAsign").css("display", "none");
                        }
                    });

                     $(tbody).on('click', '#unasign-' + users[i].id + '-' + i, function () {
                        var id = $(this).attr('id');

                        var split = id.split('-');
                        var iduser = split[1];

                        $("#gestionAsign .modal-content header h2").text("Eliminar Evaluación");
                        $("#gestionAsign .modal-content form button").text("Eliminar");

                        $(".slctEva").getUserEvaluations("../assets/php/getAsigns.php", iduser);

                        $(".txtiduser").val(iduser);    
                    });

                    var closasign = $('#unasign-' + users[i].id + '-' + i).animatedModal({
                        modalTarget: 'gestionAsign',
                        animatedIn: 'slideInUp',
                        animatedOut: 'slideOutDown',
                        color: '#f5fafa',
                        beforeOpen: function () {
                            $("#gestionAsign").css("display", "block");
                        },
                        afterOpen: function () {
                            console.log("The animation is completed");
                        },
                        beforeClose: function () {
                            console.log("The animation was called");
                        },
                        afterClose: function () {
                            $("#gestionAsign").css("display", "none");
                        }
                    });


                    $(tbody).on('click', '#edit-' + users[i].id + '-' + i, function () {
                        var id = $(this).attr('id');

                        var split = id.split('-');
                        var info = users[split[2]];

                        $(".txtiduser").val(info.id);
                        $(".txtname").val(info.name);
                        $(".txtemail").val(info.email);
                        $(".txtusername").val(info.username);
                        $(".pass1").val(info.password);
                        $(".pass2").val(info.password);
                        $(".txtdate").val(info.fecha);
                        $('.slctTipo').find('option:contains("' + info.tipo + '")').attr("selected", true);

                        $("#gestion .modal-content form").changeInputsState(false);
                        $("#gestion .modal-content header h2").text("Editar Usuario");
                        $("#gestion .modal-content form button").text("Actualizar");
                    });

                    var closedit = $('#edit-' + users[i].id + '-' + i).animatedModal({
                        modalTarget: 'gestion',
                        animatedIn: 'slideInUp',
                        animatedOut: 'slideOutDown',
                        color: '#f5fafa',
                        beforeOpen: function () {
                            $("#gestion").css("display", "block");
                        },
                        afterOpen: function () {
                            console.log("The animation is completed");
                        },
                        beforeClose: function () {
                            console.log("The animation was called");
                        },
                        afterClose: function () {
                            $("#gestion").css("display", "none");
                        }
                    });

                    $(tbody).on('click', '#del-' + users[i].id + '-' + i, function () {
                        var id = $(this).attr('id');

                        var split = id.split('-');
                        var info = users[split[2]];

                        $(".txtiduser").val(info.id);
                        $(".txtname").val(info.name);
                        $(".txtemail").val(info.email);
                        $(".txtusername").val(info.username);
                        $(".pass1").val(info.password);
                        $(".pass2").val(info.password);
                        $(".txtdate").val(info.fecha);
                        $('.slctTipo').find('option:contains("' + info.tipo + '")').attr("selected", true);

                        $("#gestion .modal-content form").changeInputsState(true);
                        $("#gestion .modal-content header h2").text("Baja de Usuario");
                        $("#gestion .modal-content form button").text("Dar de Baja");
                    });

                    var closedel = $('#del-' + users[i].id + '-' + i).animatedModal({
                        modalTarget: 'gestion',
                        animatedIn: 'slideInUp',
                        animatedOut: 'slideOutDown',
                        color: '#f5fafa',
                        beforeOpen: function () {
                            $("#gestion").css("display", "block");
                        },
                        afterOpen: function () {
                            console.log("The animation is completed");
                        },
                        beforeClose: function () {
                            console.log("The animation was called");
                        },
                        afterClose: function () {
                            $("#gestion").css("display", "none");
                        }
                    });
                    break;
                case 2:
                    //EVAS
                    var actions = null;

                    switch (userType) {
                        case "Administrador":
                            actions = '<tr><td>' + users[i].idEva + '</td><td>' + users[i].title + '</td><td>' + users[i].num + '</td><td>' + users[i].theme + '</td><td>' + users[i].type + '</td><td>' + users[i].date + '</td><td class="actions"><ul class="icons"><li><a id="editEva-' + users[i].idEva + '-' + i + '" href="#gestionEva" class="icon fa-pencil"><span class="label">Editar</span></a></li><li><a id="delEva-' + users[i].idEva + '-' + i + '" href="#gestionEva" class="icon fa-trash-o"><span class="label">Eliminar</span></a></li><li><a id="go2Eva-' + users[i].idEva + '-' + i + '" target="_blank" class="icon fa-eye"><span class="label">Ver</span></a></li></ul></td></tr>';
                            break;
                        case "Especialista":

                            if (users[i].owner == idUser) {
                                actions = '<tr><td>' + users[i].idEva + '</td><td>' + users[i].title + '</td><td>' + users[i].num + '</td><td>' + users[i].theme + '</td><td>' + users[i].type + '</td><td>' + users[i].date + '</td><td class="actions"><ul class="icons"><li><a id="editEva-' + users[i].idEva + '-' + i + '" href="#gestionEva" class="icon fa-pencil"><span class="label">Editar</span></a></li><li><a id="delEva-' + users[i].idEva + '-' + i + '" href="#gestionEva" class="icon fa-trash-o"><span class="label">Eliminar</span></a></li><li><a id="go2Eva-' + users[i].idEva + '-' + i + '" target="_blank" class="icon fa-eye"><span class="label">Ver</span></a></li></ul></td></tr>';
                            } else {
                                actions = '<tr><td>' + users[i].idEva + '</td><td>' + users[i].title + '</td><td>' + users[i].num + '</td><td>' + users[i].theme + '</td><td>' + users[i].type + '</td><td>' + users[i].date + '</td><td class="actions"><ul class="icons"><li><a id="go2Eva-' + users[i].idEva + '-' + i + '" target="_blank" class="icon fa-eye"><span class="label">Ver</span></a></li></ul></td></tr>';
                            }

                            break;
                    }
                    $(tbody).append(actions);

                    $(tbody).on('click', '#editEva-' + users[i].idEva + '-' + i, function () {
                        var id = $(this).attr('id');

                        var split = id.split('-');
                        var info = users[split[2]];

                        $(".txtidEva").val(info.idEva);
                        $(".txtTitulo").val(info.title);
                        $(".txtNum").val(info.num);
                        $(".slctTema").find('option:contains("' + info.theme + '")').attr("selected", true);
                        $(".slctTipoEva").find('option:contains("' + info.type + '")').attr("selected", true);

                        $("#gestionEva .modal-content form").changeInputsState(false);
                        $("#gestionEva .modal-content header h2").text("Editar Evaluación");
                        $("#gestionEva .modal-content form button").text("Editar");

                    });

                    var closeditEva = $('#editEva-' + users[i].idEva + '-' + i).animatedModal({
                        modalTarget: 'gestionEva',
                        animatedIn: 'slideInUp',
                        animatedOut: 'slideOutDown',
                        color: '#f5fafa',
                        beforeOpen: function () {
                            $("#gestionEva").css("display", "block");
                        },
                        afterOpen: function () {
                            console.log("The animation is completed");
                        },
                        beforeClose: function () {
                            console.log("The animation was called");
                        },
                        afterClose: function () {
                            $("#gestionEva").css("display", "none");
                        }
                    });

                    $(tbody).on('click', '#delEva-' + users[i].idEva + '-' + i, function () {
                        var id = $(this).attr('id');

                        var split = id.split('-');
                        var info = users[split[2]];

                        $(".txtidEva").val(info.idEva);
                        $(".txtTitulo").val(info.title);
                        $(".txtNum").val(info.num);
                        $(".slctTema").find('option:contains("' + info.theme + '")').attr("selected", true);
                        $(".slctTipoEva").find('option:contains("' + info.type + '")').attr("selected", true);

                        $("#gestionEva .modal-content form").changeInputsState(true);
                        $("#gestionEva .modal-content header h2").text("Eliminar Evaluación");
                        $("#gestionEva .modal-content form button").text("Eliminar");
                    });
                    var closeditEva = $('#delEva-' + users[i].idEva + '-' + i).animatedModal({
                        modalTarget: 'gestionEva',
                        animatedIn: 'slideInUp',
                        animatedOut: 'slideOutDown',
                        color: '#f5fafa',
                        beforeOpen: function () {
                            $("#gestionEva").css("display", "block");
                        },
                        afterOpen: function () {
                            console.log("The animation is completed");
                        },
                        beforeClose: function () {
                            console.log("The animation was called");
                        },
                        afterClose: function () {
                            $("#gestionEva").css("display", "none");
                        }
                    });

                    $(tbody).on('click', '#go2Eva-' + users[i].idEva + '-' + i, function () {
                        var id = $(this).attr('id');

                        var split = id.split('-');
                        var info = users[split[2]];
                        var json = JSON.stringify(info);
                        openPopupPage("../eva/index.php", json);
                    });
                    break;
                case 3:
                    //THEMES
                    $(tbody).append('<tr><td>' + users[i].id + '</td><td>' + users[i].etiqueta + '</td><td class="actions"><ul class="icons"><li><a id="editTheme-' + users[i].id + '-' + i + '" href="#gestionTheme" class="icon fa-pencil"><span class="label">Editar</span></a></li><li><a id="delTheme-' + users[i].id + '-' + i + '" href="#gestionTheme" class="icon fa-trash-o"><span class="label">Eliminar</span></a></li></ul></td></tr>');

                    $(tbody).on('click', '#editTheme-' + users[i].id + '-' + i, function () {
                        var id = $(this).attr('id');

                        var split = id.split('-');
                        var info = users[split[2]];

                        $(".txtidTheme").val(info.id);
                        $(".txtTema").val(info.etiqueta);
                        $("#gestionTheme .modal-content form").changeInputsState(false);
                        $("#gestionTheme .modal-content header h2").text("Editar Tema");
                        $("#gestionTheme .modal-content form button").text("Editar");
                    });

                    var closeventTheme = $('#editTheme-' + users[i].id + '-' + i).animatedModal({
                        modalTarget: 'gestionTheme',
                        animatedIn: 'slideInUp',
                        animatedOut: 'slideOutDown',
                        color: '#f5fafa',
                        beforeOpen: function () {
                            $("#gestionTheme").css("display", "block");
                        },
                        afterOpen: function () {
                            console.log("The animation is completed");
                        },
                        beforeClose: function () {
                            console.log("The animation was called");
                        },
                        afterClose: function () {
                            $("#gestionTheme").css("display", "none");
                        }
                    });

                    $(tbody).on('click', '#delTheme-' + users[i].id + '-' + i, function () {
                        var id = $(this).attr('id');

                        var split = id.split('-');
                        var info = users[split[2]];

                        $(".txtidTheme").val(info.id);
                        $(".txtTema").val(info.etiqueta);
                        $("#gestionTheme .modal-content form").changeInputsState(true);
                        $("#gestionTheme .modal-content header h2").text("Eliminar Tema");
                        $("#gestionTheme .modal-content form button").text("Eliminar");
                    });

                    var closeventTheme = $('#delTheme-' + users[i].id + '-' + i).animatedModal({
                        modalTarget: 'gestionTheme',
                        animatedIn: 'slideInUp',
                        animatedOut: 'slideOutDown',
                        color: '#f5fafa',
                        beforeOpen: function () {
                            $("#gestionTheme").css("display", "block");
                        },
                        afterOpen: function () {
                            console.log("The animation is completed");
                        },
                        beforeClose: function () {
                            console.log("The animation was called");
                        },
                        afterClose: function () {
                            $("#gestionTheme").css("display", "none");
                        }
                    });
                    break;
            }
        }
    });
};

$("#add-modal").off("click").on("click", function (e) {
    e.preventDefault();
    $("#gestion .modal-content form").changeInputsState(false);
    $("#gestion .modal-content header h2").text("Alta de Usuario");
    $("#gestion .modal-content form button").text("Dar de Alta");
});

$("#add-Theme").off("click").on("click", function (e) {
    e.preventDefault();
    $("#gestionTheme .modal-content form").changeInputsState(false);
    $("#gestionTheme .modal-content header h2").text("Agregar Tema");
    $("#gestionTheme .modal-content form button").text("Agregar");
});

jQuery.fn.fillData = function (path) {
    var slctType = $(this);
    var tipos = Array();

    $.get(path, function (data) {
        if (data.success == "true") {
            for (var i = 0; i < data.stuff.length; i++) {
                tipos[i] = data.stuff[i];
            }
        } else {
            alert("falla al cargar datos intenta de nuevo mas tarde...");
        }
    }, 'json').done(function () {

    }).fail(function (xhr, status, error) {
        alert("Error intenta de nuevo...");
    }).always(function () {
        slctType.empty();
        slctType.append($("<option />").text("Seleccionar"));
        for (var i = 0; i < tipos.length; i++) {
            slctType.append($("<option />").val(tipos[i].id).text(tipos[i].etiqueta));
        }
    });
};

jQuery.fn.addUser = function (path, close) {
    var form = $(this);

    var fields = form.serializeArray();

    if (validateFields(fields, 1)) {
        $.post(path, {
            formdata: fields,
            petition: "insert"
        }, function (data) {
            if (data == "1") {
                updateTable("../assets/php/allUsers.php", ".userTable .tbl-content table", ".userTable .tbl-content .loader", 1);
                alert("Usuario agregado exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {
            close.click();
        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {

        });
    }
}

jQuery.fn.editUser = function (id, path, close) {
    var form = $(this);

    var fields = form.serializeArray();


    if (validateFields(fields, 1)) {
        $.post(path, {
            iduser: id,
            formdata: fields,
            petition: "update"
        }, function (data) {
            if (data == "1") {
                updateTable("../assets/php/allUsers.php", ".userTable .tbl-content table", ".userTable .tbl-content .loader", 1);
                alert("Usuario editado exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {
            close.click();
        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {

        });
    }
}

jQuery.fn.deleteUser = function (id, path, close) {
    var form = $(this);

    form.changeInputsState(false);
    var fields = form.serializeArray();

    if (validateFields(fields, 1)) {
        $.post(path, {
            iduser: id,
            formdata: fields,
            petition: "delete"
        }, function (data) {
            if (data == "1") {
                updateTable("../assets/php/allUsers.php", ".userTable .tbl-content table", ".userTable .tbl-content .loader", 1);
                alert("Usuario eliminado exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {
            close.click();
        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {

        });
    }
}

var validateFields = function (fields, formType) {
    switch (formType) {
        case 1:
            for (var i = 0; i < fields.length; i++) {
                if (fields[i].value == "") {
                    alert("Campo vacío detectado...");
                    return false;
                }
            }
            if (fields[3]['value'] != fields[4]['value']) {
                alert("las contraseñas no coinciden...");
                return false;
            }
            return true;
            break;
        case 2:
            for (var i = 0; i < fields.length; i++) {
                if (fields[i].value == "") {
                    alert("Campo vacío detectado...");
                    return false;
                }
            }
            return true;
            break;
    }
};

jQuery.fn.changeInputsState = function (cond) {
    var form = $(this);
    form.find("input").each(function (index, el) {
        $(el).prop('disabled', cond);
    });
};

jQuery.fn.getEvaluations = function (path) {
    var slctType = $(this);
    var evas = Array();

    $.get(path, function (data) {
        if (data.success == "true") {
            for (var i = 0; i < data.stuff.length; i++) {
                evas[i] = data.stuff[i];
            }
        } else {
            if (data.stuff.length > 0) {
                alert("falla al cargar evaluaciones intenta de nuevo mas tarde...");
            }
        }
    }, 'json').done(function () {

    }).fail(function (xhr, status, error) {
        alert("Error intenta de nuevo...");
    }).always(function () {
        slctType.empty();
        slctType.append($("<option />").text("Evaluacion"));
        for (var i = 0; i < evas.length; i++) {
            slctType.append($("<option />").val(evas[i].idEva).text(evas[i].titulo));
        }
    });
};

jQuery.fn.getUserEvaluations = function (path, idUser) {
    var slctType = $(this);
    var evas = Array();

    $.post(path,{id:idUser}, function (data) {
        if (data.success == "true") {
            for (var i = 0; i < data.stuff.length; i++) {
                evas[i] = data.stuff[i];
            }
        } else {
            if (data.stuff.length > 0) {
                alert("falla al cargar evaluaciones intenta de nuevo mas tarde...");
            }else{
                alert("Este usuario no cuenta con evaluaciones asignadas.");
            }
        }
    }, 'json').done(function () {

    }).fail(function (xhr, status, error) {
        alert("Error intenta de nuevo...");
    }).always(function () {
        slctType.empty();
        slctType.append($("<option />").text("Evaluacion"));
        for (var i = 0; i < evas.length; i++) {
            slctType.append($("<option />").val(evas[i].idEva).text(evas[i].titulo));
        }
    });
};

jQuery.fn.addEva = function (path, syncPath) {
    var form = $(this);

    var fields = form.serializeArray();

    if (validateFields(fields, 2)) {
        $.post(path, {
            formdata: fields,
            petition: "insert"
        }, function (data) {
            if (data.includes("true")) {
                alert("Evaluación agregada exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {

        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {
            $(".slctEva").getEvaluations(syncPath + "evas.php");
            updateTable(syncPath + "allEvas.php", ".evaTable .tbl-content table", ".evaTable .tbl-content .loader", 2);
        });
    }
};

jQuery.fn.editEva = function (id, path, close, consult) {
    var form = $(this);

    var fields = form.serializeArray();


    if (validateFields(fields, 2)) {
        $.post(path, {
            idEva: id,
            formdata: fields,
            petition: "update"
        }, function (data) {
            if (data.includes("true")) {
                alert("Evaluación editada exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {
            close.click();
        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {
            updateTable(consult, ".evaTable .tbl-content table", ".evaTable .tbl-content .loader", 2);
        });
    }
}

jQuery.fn.deleteEva = function (id, path, close, consult) {
    var form = $(this);

    form.changeInputsState(false);
    var fields = form.serializeArray();

    if (validateFields(fields, 2)) {
        $.post(path, {
            idEva: id,
            formdata: fields,
            petition: "delete"
        }, function (data) {
            if (data.includes("true")) {
                alert("Evaluación eliminada exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {
            close.click();
        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {
            updateTable(consult, ".evaTable .tbl-content table", ".evaTable .tbl-content .loader", 2);
        });
    }
}

jQuery.fn.evaInfo = function (path) {

    var id = $(this).val();
    $(".txtNum").text("Numero de Preguntas: ");
    $(".txtTipo").text("Tipo: ");
    $(".txtTema").text("Tema: ");
    $("#add-questions footer.eva form").empty();
    if (id != "Evaluacion") {
        var evadata;
        $.post(path, {
            idEva: id
        }, function (data) {
            if (data.success == "true") {
                evadata = data;
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }, 'json').done(function () {

        }).fail(function (xhr, status, error) {
            $(".txtNum").text("Numero de Preguntas: ");
            $(".txtTipo").text("Tipo: ");
            $(".txtTema").text("Tema: ");
            alert("Error intenta de nuevo...");
        }).always(function () {

            var tipo = evadata.stuff[0].tipo,
                tema = evadata.stuff[0].tema;
            $(".txtTipo").text("Tipo: " + tipo);
            $(".txtTema").text("Tema: " + tema);

        });
    }
};

jQuery.fn.addQuestions = function (path, type, theme) {
    var form = $(this);

    var fields = form.serializeArray();
    var preguntas = Array();
    var respuestas = Array();
    var p = 0,
        r = 0;
    for (var i = 0; i < fields.length; i++) {
        if (fields[i]['name'].includes('-')) {
            respuestas[r] = fields[i];
            r++;
        } else {
            preguntas[p] = fields[i];
            p++;
        }
    }

    if (validateFields(fields, 2)) {
        $.post(path, {
            pregs: preguntas,
            resps: respuestas,
            evaType: type,
            evaTheme: theme
        }, function (data) {
            if (data.includes("true")) {
                alert("Preguntas agregadas exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {

        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {
            $("#add-questions footer.eva form").empty();
        });
    }
};

jQuery.fn.getQuestions = function (path){
    var table = ".QstnTable .tbl-content table";
    var tbody = table + " tbody";
    var loader = ".QstnTable .tbl-content .loader";
    var questions;


    $(table).hide();
    $(loader).show();
    
    $.get(path, function (data) {
        if (data.status.includes("true")) {
           questions = data.stuff;
        } else {
            alert(data.msg);
        }
    }, 'json').done(function () {
        $(loader).hide();
        $(table).show();
    }).fail(function (xhr, status, error) {
        alert("Error intenta de nuevo...");
    }).always(function () {
        $(tbody).empty();
        for(var i = 0; i < questions.length; i++){
            var p = questions[i].pregunta;
            var r = questions[i].respuesta;
            var respuestas = "";
            for(var j = 0; j < r.length; j++){
                respuestas += r[j].respuesta + ",";
            }
            var actions = "<tr><td>"+p+"</td><td>"+respuestas+"</td><td>"+questions[i].tema+"</td><td>"+questions[i].tipo+"</td><td class='actions'><ul class='icons'><li><a class='icon fa-minus' id='qstn-"+questions[i].idPregunta+"'><span class='label'>Ver</span></a></li></ul></td></tr>";

            $(tbody).on("click", "#qstn-"+i, function(){
                var C = confirm("Estas seguro que deseas eliminar esta pregunta?");
                if (C == true) {
                    var id = $(this).attr('id').split('-')[1];
                    $.post("../assets/php/delQstn.php", {
                        idPregunta: id
                    }, function (data) {
                        if (data.includes("true")) {
                            alert("Pregunta eliminada exitosamente");
                        } else {
                            alert("Hubo un error intente de nuevo mas tarde...");
                        }
                    }).done(function () {
            
                    }).fail(function (xhr, status, error) {
                        alert("Error intenta de nuevo...");
                    }).always(function () {
                        $(".QstnTable").getQuestions(path);
                    });
                } 
            });

            $(tbody).append(actions);
        }
    });
};

jQuery.fn.addTheme = function (path, close) {
    var form = $(this);

    var fields = form.serializeArray();

    if (validateFields(fields, 2)) {
        $.post(path, {
            formdata: fields,
            petition: "insert"
        }, function (data) {
            if (data.includes("true")) {
                alert("Tema agregado exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {
            close.click();
        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {
            updateTable("../../assets/php/temas.php", ".themeTable .tbl-content table", ".themeTable .tbl-content .loader", 3);
        });
    }
};

jQuery.fn.editTheme = function (id, path, close) {
    var form = $(this);

    var fields = form.serializeArray();


    if (validateFields(fields, 2)) {
        $.post(path, {
            idTheme: id,
            formdata: fields,
            petition: "update"
        }, function (data) {
            if (data.includes("true")) {
                alert("Tema editado exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {
            close.click();
        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {
            updateTable("../../assets/php/temas.php", ".themeTable .tbl-content table", ".themeTable .tbl-content .loader", 3);
        });
    }
}

jQuery.fn.deleteTheme = function (id, path, close) {
    var form = $(this);

    form.changeInputsState(false);
    var fields = form.serializeArray();

    if (validateFields(fields, 2)) {
        $.post(path, {
            idTheme: id,
            formdata: fields,
            petition: "delete"
        }, function (data) {
            if (data.includes("true")) {
                alert("Tema eliminado exitosamente");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {
            close.click();
        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {
            updateTable("../../assets/php/temas.php", ".themeTable .tbl-content table", ".themeTable .tbl-content .loader", 3);
        });
    }
}

jQuery.fn.asignEva = function (path) {
    var form = $(this);

    var fields = form.serializeArray();
    $.post(path, {
        formdata: fields
    }, function (data) {
        if (data.includes("true")) {
            alert("Evaluación asignada correctamente");
        }else if(data.includes("exists")){
            alert("No se puede asignar de nuevo esta evaluaciíon a este usuario");
        }
         else {
            alert("Hubo un error intente de nuevo mas tarde...");
        }
    }).done(function () {

    }).fail(function (xhr, status, error) {
        alert("Error intenta de nuevo...");
    }).always(function () {
    });
}

jQuery.fn.deleteEva = function (path) {
    var form = $(this);

    form.changeInputsState(false);
    var fields = form.serializeArray();

    if (validateFields(fields, 2)) {
        $.post(path, {
            fields: fields
        }, function (data) {
            if (data.includes("true")) {
                alert("Asignación eliminada.");
            } else {
                alert("Hubo un error intente de nuevo mas tarde...");
            }
        }).done(function () {
           
        }).fail(function (xhr, status, error) {
            alert("Error intenta de nuevo...");
        }).always(function () {
            
        });
    }
}

jQuery.fn.getUserEva = function (path, iduser, method) {
    var evas = Array();
    switch (method) {
        case 1:
            var tbody = $(this).children("tbody");
            $(tbody).empty();

            $.post(path, { id: iduser }, function (data) {
                if (data.success == "true") {
                    for (var i = 0; i < data.stuff.length; i++) {
                        evas[i] = data.stuff[i];
                    }
                } else if (data.stuff.length <= 0) {
                    alert("Este usuario no tiene evaluaciones asignadas");
                } else {
                    alert("falla al cargar evaluaciones intenta de nuevo mas tarde...");
                }
            }, 'json').done(function () {

            }).fail(function (xhr, status, error) {
                alert("Error intenta de nuevo...");
            }).always(function () {
                var linkaction = "";
                for (var i = 0; i < evas.length; i++) {

                    var score = "";
                    if( evas[i].score != ""){
                        score = evas[i].score + "%";
                    }

                    if(evas[i].media != ""){
                        linkaction = "<a id='open-"+evas[i].idEva+"' href='#overview' data-media='"+evas[i].media+"'><i class='fas fa-file-video'/></a>";
                    }

                    tbody.append("<tr><td>" + evas[i].titulo + "</td><td>" + evas[i].num + "</td><td>" + evas[i].tema + "</td><td>" + evas[i].tipo + "</td><td>" + evas[i].date + "</td><td>" + evas[i].status +"</br>"+ linkaction +"</td><td>" + score+"</td></tr>");

                    $(document).on('click', '#open-' + evas[i].idEva, function () {
                        var media = $(this).data('media');
                        if(media != ""){
                            media = media.replace('../' , '');
                            $("#overview .modal-content .video-container video").attr("src",media);
                        }
                    });

                    var modal = $("#open-"+ evas[i].idEva).animatedModal({
                        modalTarget: 'overview',
                        animatedIn: 'slideInUp',
                        animatedOut: 'slideOutDown',
                        color: '#f5fafa',
                        beforeOpen: function() {
                            $("#overview").css("display", "block");
                        },
                        afterOpen: function() {
                            console.log("The animation is completed");
                        },
                        beforeClose: function() {
                            console.log("The animation was called");
                        },
                        afterClose: function() {
                            $("#overview").css("display", "none");
                        }
                    });
                }
            });
            break;
        case 2:
            var list = $(this).attr('id');
            $.post(path, { id: iduser }, function (data) {
                if (data.success == "true") {
                    for (var i = 0; i < data.stuff.length; i++) {
                        evas[i] = data.stuff[i];
                    }
                } else if (data.stuff.length <= 0) {
                    alert("Este usuario no tiene evaluaciones asignadas");
                } else {
                    alert("falla al cargar evaluaciones intenta de nuevo mas tarde...");
                }
            }, 'json').done(function () {

            }).fail(function (xhr, status, error) {
                alert("Error intenta de nuevo...");
            }).always(function () {

                for (var i = 0; i < evas.length; i++) {
                    var score = evas[i].score;
                    if(score == ""){
                        score="";
                    }else{
                        score+="%";
                    }
                    var video = evas[i].media;
                    var media;
                    if(video == ""){
                        media = "";
                    }else{
                        video = video.replace('../', '');
                        media = '<video width="400" controls><source src='+ video +' type="video/webm">Your browser does not support HTML5 video.</video>';
                    }
                   
                    var options = {
                        valueNames: [
                            'titulo',
                            'fecha'
                        ],
                        item: '<li class="eva-' + evas[i].idEva + '-' + i + '"><div><h3 class="titulo"></h3><p class="fecha"></p></div><div><h3 class="score">'+score+'</h3><i class="fas fa-caret-square-right"></i>'+media+'</div></li>'
                    };

                    var evasList = new List(list, options);

                    evasList.add({ titulo: evas[i].titulo + " - " + evas[i].status, fecha: evas[i].date });

                    $("#" + list).on('click', '.eva-' + evas[i].idEva + '-' + i, function () {
                        var id = $(this).attr('class');
                        var split = id.split('-');
                        var info = evas[split[2]];
                        var json = JSON.stringify(info);
                        openPopupPage("../eva/index.php", json);
                    });
                }
            });
            break;
    }
}


function openPopupPage(relativeUrl, info) {
    var param = {
        'info': info
    };
    OpenWindowWithPost(relativeUrl, "Evaluacion", param);
}

function OpenWindowWithPost(url, name, params) {
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", url);
    form.setAttribute("target", name);
    for (var i in params) {
        if (params.hasOwnProperty(i)) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = i;
            input.value = params[i];
            form.appendChild(input);
        }
    }
    document.body.appendChild(form);
    //note I am using a post.htm page since I did not want to make double request to the page
    //it might have some Page_Load call which might screw things up.
    window.open("post.htm", name);
    form.submit();
    document.body.removeChild(form);
}