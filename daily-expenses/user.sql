CREATE TABLE Users (
    email VARCHAR(255) PRIMARY KEY,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    currency VARCHAR(10),
    password VARCHAR(255)
);

CREATE TABLE Income (
    email VARCHAR(255),
    income_type VARCHAR(100),
    income DECIMAL(15, 2),
    date DATE,
    FOREIGN KEY (email) REFERENCES Users(email)
);

CREATE TABLE Expenses (
    email VARCHAR(255),
    category VARCHAR(100),
    amount DECIMAL(15, 2),
    date DATE,
    payee VARCHAR(255),
    description TEXT,
    FOREIGN KEY (email) REFERENCES Users(email)
);



CREATE TABLE Savings (
    email VARCHAR(255) PRIMARY KEY,
    total_savings DECIMAL(15, 2),
    FOREIGN KEY (email) REFERENCES Users(email)
);
