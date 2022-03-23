<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container-xl">
  <div class="jumbotron">
  <h1>BEAUTIFUL CRUD APP DEMO V.1</h1>
  <p class="bg-info">Create, read, update, and delete records below:</p>
  <table class="table table-bordered">
    <tbody>
      <?php include 'read.php'; ?>
    </tbody>
  </table>

  <form class="form-inline m-2" action="create.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" class="form-control m-2" id="name" name="name">
    <label for="score">Score:</label>
    <input type="number" class="form-control m-2" id="score" name="score">
    <button type="submit" class="btn btn-primary">Add</button>
  </form>

  <blockquote>
    <p class="lead">!! THIS IS A BEAUTIFUL CRUD APP RUNNING ON EKS-CLUSTER PROVISIONED WITH CROSSPLANE + ARGOCD USING GITOPS PRINCIPLE !!</p>
    <footer class="lead">Mohit Verma</footer>
  </blockquote>
  

</div>

</body>
</html>
