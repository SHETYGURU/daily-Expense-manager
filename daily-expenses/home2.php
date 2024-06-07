<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    overflow-x: hidden;
  }

  .container {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
  }

  .button {
    margin: 10px;
    padding: 10px 20px;
    border: none;
    border-radius: 2cm;
    background-color: #a9a9a9;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
  }

  .button:hover {
    background-color: #808080;
    transform: scale(1.05);
    box-shadow: 0px 0px 5px blue;
  }

  .menu-button {
    position: fixed;
    top: 20px;
    right: 20px;
    background: none;
    border: none;
    cursor: pointer;
  }

  .menu {
    position: fixed;
    top: 0;
    right: -250px;
    width: 250px;
    height: 100%;
    background-color: #f2f2f2;
    box-shadow: -5px 0px 5px rgba(0, 0, 0, 0.1);
    transition: right 0.3s;
  }

  .menu.active {
    right: 0;
  }

  .menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #ddd;
  }

  .close-button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
  }

  .menu-links {
    margin-top: 20px;
    padding: 0;
    list-style: none;
  }

  .menu-link {
    padding: 10px;
    text-align: center;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s;
  }

  .menu-link:hover {
    background-color: #ddd;
  }

  @media (max-width: 768px) {
    .buttons {
      flex-direction: column;
      align-items: center;
    }

    .button {
      width: 80%; /* Adjust as needed */
    }

    .menu-button {
      top: auto;
      bottom: 20px;
      right: 20px;
    }
  }
</style>
</head>
<body>
  <div class="container">
    <div class="buttons">
      <button class="button">Add income</button>
      <button class="button">Add expense</button>
      <button class="button">View stats</button>
      <button class="button">My savings</button>
      <button class="menu-button">
        <img src="setting icon.png" alt="Menu" width="30">
      </button>
    </div>
    <div class="menu">
      <div class="menu-header">
        <button class="close-button">&times;</button>
      </div>
      <ul class="menu-links">
      <li class="menu-link"><a href="profile.php">Profile</a></li>
        <li class="menu-link">logout</li>
        <li class="menu-link">delete account</li>
      </ul>
    </div>
  </div>
  <script>
    const menuButton = document.querySelector('.menu-button');
    const closeButton = document.querySelector('.close-button');
    const menu = document.querySelector('.menu');

    menuButton.addEventListener('click', () => {
      menu.classList.toggle('active');
    });

    closeButton.addEventListener('click', () => {
      menu.classList.remove('active');
    });
  </script>
</body>
</html>
