<?php

if(isset($_POST['submit'])){

  include_once('config.php');

  $email = $_POST['email'];
  $nome = $_POST['nome'];
  $sobrenome = $_POST['sobrenome'];
  $senha = $_POST['senha'];
  $senhadeconfirmacao = $_POST['senhadeconfirmacao'];

  $result = mysqli_query($conexao, "INSERT INTO usuarios(email, nome, sobrenome, senha, Confirmação de senha) 
  VALUES('$email, $nome, $sobrenome, $senha, $senhadeconfirmacao)");

  header("Location: login.php");

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Form de Registro com validações em JS</title>

  <style>
    /* geral */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Helvetica, sans-serif;
  color: #323232;
  border: none;
}

input, label {
  display: block;
  outline: none;
  width: 100%;
}

a {
  color: #00ffff;
}

body {
  padding-top: 15vh;
  background-color: #3d3d3d;
  background-size: cover;
  background-position-y: -150px;
}

/* form */
#main-container {
  width: 500px;
  margin-left: auto;
  margin-right: auto;
  background-color: #FFF;
  border-radius: 10px;
  padding: 25px;
}

#main-container h1 {
  text-align: center;
  margin-bottom: 25px;
  font-size: 1.6rem;
}

form {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.full-box {
  flex: 1 1 100%;
  position: relative;
}

.half-box {
  flex: 1 1 45%;
  position: relative;
}

.spacing {
  margin-right: 2.5%;
}

label {
  font-weight: bold;
  font-size: .8rem;
}

input {
  border-bottom: 2px solid #323232;
  padding: 10px;
  font-size: .9rem;
  margin-bottom: 40px;
}

input:focus {
  border-color: #00dfd0;
}

input[type="submit"] {
  background-color: #00dfd0;
  color: #000;
  border: none;
  border-radius: 20px;
  height: 40px;
  cursor: pointer;
}

#agreement {
  margin-right: 5px;
}

#agreement, #agreement-label {
  display: inline-block;
  width: auto;
}

.error-validation {
  color: #ff1a1a;
  position: absolute;
  top: 57px;
  font-size: 12px;
}

.template {
  display: none;
}
  </style>
  
</head>
<body>
  <div id="main-container">
    <h1>Cadastre-se para acessar o sistema</h1>
    <form id="register-form" action="formulario.php" method="POST">
      <div class="full-box">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Digite seu e-mail" data-min-length="2" data-email-validate>
      </div>
      <div class="half-box spacing">
          <label for="name">Nome</label>
          <input type="text" name="nome" id="name" placeholder="Digite seu nome" data-required data-min-length="3" data-max-length="16">
      </div>
      <div class="half-box">
          <label for="lastname">Sobrenome</label>
          <input type="text" name="sobrenome" id="lastname" placeholder="Digite seu sobrenome" data-required data-only-letters>
      </div>
      <div class="half-box spacing">
        <label for="pasword">Senha</label>
        <input type="password" name="senha" id="password" placeholder="Digite sua senha" data-password-validate data-required>
      </div>
      <div class="half-box">
        <label for="passconfirmation">Confirmação de senha</label>
        <input type="password" name="senhadeconfirmacao" id="passwordconfirmation" placeholder="Digite novamente sua senha" data-equal="password">
      </div>
      <div>
        <input type="checkbox" name="agreement" id="agreement">
        <label for="agreement" id="agreement-label">Eu li e aceito os <a href="#">termos de uso</a></label>
      </div>
      <div class="full-box">
        <input id="btn-submit" type="submit" name="submit" value="Registrar">
      </div>
    </form>
  </div>
  <p class="error-validation template"></p>
  <script>
    class Validator {

constructor() {
  this.validations = [
    'data-min-length',
    'data-max-length',
    'data-only-letters',
    'data-email-validate',
    'data-required',
    'data-equal',
    'data-password-validate',
  ]
}

// inicia a validação de todos os campos
validate(form) {

  // limpa todas as validações antigas
  let currentValidations = document.querySelectorAll('form .error-validation');

  if(currentValidations.length) {
    this.cleanValidations(currentValidations);
  }

  // pegar todos inputs
  let inputs = form.getElementsByTagName('input');
  // transformar HTMLCollection em array
  let inputsArray = [...inputs];

  // loop nos inputs e validação mediante aos atributos encontrados
  inputsArray.forEach(function(input) {

    // fazer validação de acordo com o atributo do input
    for(let i = 0; this.validations.length > i; i++) {
      if(input.getAttribute(this.validations[i]) != null) {

        // limpa string para saber o método
        let method = this.validations[i].replace("data-", "").replace("-", "");

        // valor do input
        let value = input.getAttribute(this.validations[i])

        // invoca o método
        this[method](input,value);

      }
    }

  }, this);

}

// método para validar se tem um mínimo de caracteres
minlength(input, minValue) {

  let inputLength = input.value.length;

  let errorMessage = `O campo precisa ter pelo menos ${minValue} caracteres`;

  if(inputLength < minValue) {
    this.printMessage(input, errorMessage);
  }

}

// método para validar se passou do máximo de caracteres
maxlength(input, maxValue) {

  let inputLength = input.value.length;

  let errorMessage = `O campo precisa ter menos que ${maxValue} caracteres`;

  if(inputLength > maxValue) {
    this.printMessage(input, errorMessage);
  }

}

// método para validar strings que só contem letras
onlyletters(input) {

  let re = /^[A-Za-z]+$/;;

  let inputValue = input.value;

  let errorMessage = `Este campo não aceita números nem caracteres especiais`;

  if(!re.test(inputValue)) {
    this.printMessage(input, errorMessage);
  }

}

// método para validar e-mail
emailvalidate(input) {
  let re = /\S+@\S+\.\S+/;

  let email = input.value;

  let errorMessage = `Insira um e-mail no padrão exemplo@email.com`;

  if(!re.test(email)) {
    this.printMessage(input, errorMessage);
  }

}

// verificar se um campo está igual o outro
equal(input, inputName) {

  let inputToCompare = document.getElementsByName(inputName)[0];

  let errorMessage = `Este campo precisa estar igual ao ${inputName}`;

  if(input.value != inputToCompare.value) {
    this.printMessage(input, errorMessage);
  }
}

// método para exibir inputs que são necessários
required(input) {

  let inputValue = input.value;

  if(inputValue === '') {
    let errorMessage = `Este campo é obrigatório`;

    this.printMessage(input, errorMessage);
  }

}

// validando o campo de senha
passwordvalidate(input) {

  // explodir string em array
  let charArr = input.value.split("");

  let uppercases = 0;
  let numbers = 0;

  for(let i = 0; charArr.length > i; i++) {
    if(charArr[i] === charArr[i].toUpperCase() && isNaN(parseInt(charArr[i]))) {
      uppercases++;
    } else if(!isNaN(parseInt(charArr[i]))) {
      numbers++;
    }
  }

  if(uppercases === 0 || numbers === 0) {
    let errorMessage = `A senha precisa um caractere maiúsculo e um número`;

    this.printMessage(input, errorMessage);
  }

}

// método para imprimir mensagens de erro
printMessage(input, msg) {

  // checa os erros presentes no input
  let errorsQty = input.parentNode.querySelector('.error-validation');

  // imprimir erro só se não tiver erros
  if(errorsQty === null) {
    let template = document.querySelector('.error-validation').cloneNode(true);

    template.textContent = msg;

    let inputParent = input.parentNode;

    template.classList.remove('template');

    inputParent.appendChild(template);
  }

}

// remove todas as validações para fazer a checagem novamente
cleanValidations(validations) {
  validations.forEach(el => el.remove());
}

}

let form = document.getElementById('register-form');
let submit = document.getElementById('btn-submit');

let validator = new Validator();

// evento de envio do form, que valida os inputs
submit.addEventListener('click', function(e) {
e.preventDefault();

validator.validate(form);
});


  </script>
</body>
</html>