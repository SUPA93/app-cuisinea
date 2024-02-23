<?php

function addUser(PDO $pdo, string $first_name, string $last_name, string $email, string $password)
{
    $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `role`) VALUES (:first_name, :last_name, :email, :password, :role);";
    $query = $pdo->prepare($sql);

    $password = password_hash($password, PASSWORD_DEFAULT);

    $role = 'subscriber';
    $query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':role', $role, PDO::PARAM_STR);

    return $query->execute();
}

function verifyUserLoginPassword(PDO $pdo, string $email, string $password)
{
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return false;
    }
}

function getAllUsers(PDO $pdo)
{
    $query = $pdo->prepare("SELECT * FROM users");
    $query->execute();
    return $query->fetchAll();
}

function updateUser(PDO $pdo, int $user_id, string $email, string $password, string $first_name, string $last_name,  string $role)
{
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE users 
            SET email = :email, password = :password, first_name = :first_name, last_name = :last_name, role = :role 
            WHERE id = :id";

    $query = $pdo->prepare($sql);

    $query->bindParam(':id', $user_id, PDO::PARAM_INT);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $passwordHash, PDO::PARAM_STR);
    $query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $query->bindParam(':role', $role, PDO::PARAM_STR);

    return $query->execute();
}

function getUserById(PDO $pdo, int $id)
{
    $query = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
};

function deleteUser(PDO $pdo, int $id)
{
    $query = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    return $query->execute();
}
