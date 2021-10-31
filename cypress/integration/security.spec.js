describe('security features', () => {
    context('prevents SQL injection', () => {
        it('by way of tautology', () => {
            cy.visit('http://localhost:8080');
            cy.get('nav > :nth-child(3) > a').click();
            cy.get('[type="text"]').type('\' or 1=1 --');
            cy.get('[type="submit"]').click();
            cy.get('h2').should('have.text', 'Incorrect Username/Password');
        });

        it('by way of UNION attempt', () => {
            cy.visit('http://localhost:8080/book.php?id=1%20UNION%20SELECT%202,3,4,5,6,7,8,9');
            cy.get('#book_main').should('contain.text', 'Qty: ');
            cy.get('#book_main').should('not.contain.text', 'Qty: \n');
        });

        it('by way of piggyback attempt', () => {
            cy.visit('http://localhost:8080');
            cy.get('nav > :nth-child(3) > a').click();
            cy.get('[type="text"]').type('user');
            cy.get('[type="password"]').type('\'; drop table user --');
            cy.get('[type="submit"]').click();
            cy.get('h2').should('have.text', 'Incorrect Username/Password');
        });
    });

    it('prevents cross-site scripting', () => {
        cy.visit('http://localhost:8080/book.php?id=3%3Cscript%20type=%E2%80%9Dtext/javascript%E2%80%9D%3Ealert(%22test%22);%3C/script%3E');
        cy.get('#book_main').should('contain.text', 'Qty: ');
    });

    context('enforces strong password requirements', () => {
        beforeEach(() => {
            cy.visit('http://localhost:8080/register.php');
            cy.get('#usn').type('new-user');
            cy.get('#nam').type('Test User');
        });

        it('when the passwords do not match', () => {
            cy.get('#passwd').type('Strong1234');
            cy.get('#conpasswd').type('AlsoStrongButDoesNotMatch5678');
            cy.get('[type="submit"]').click();
            cy.get('h2').should('have.text', 'The two passwords provided do not match.');
        });

        it('when the passwords do not contain lower case characters', () => {
            cy.get('#passwd').type('STRONG1234');
            cy.get('#conpasswd').type('STRONG1234');
            cy.get('[type="submit"]').click();
            cy.get('h2').should('have.text', 'Password must contain at least one of all of the following: upper case letter, lower case letter, and number.');
        });

        it('when the passwords do not contain upper case characters', () => {
            cy.get('#passwd').type('strong1234');
            cy.get('#conpasswd').type('strong1234');
            cy.get('[type="submit"]').click();
            cy.get('h2').should('have.text', 'Password must contain at least one of all of the following: upper case letter, lower case letter, and number.');
        });

        it('when the passwords do not contain numbers', () => {
            cy.get('#passwd').type('strong1234');
            cy.get('#conpasswd').type('strong1234');
            cy.get('[type="submit"]').click();
            cy.get('h2').should('have.text', 'Password must contain at least one of all of the following: upper case letter, lower case letter, and number.');
        });

        it('when the passwords are not long enough', () => {
            cy.get('#passwd').type('Str1234');
            cy.get('#conpasswd').type('Str1234');
            cy.get('[type="submit"]').click();
            cy.get('h2').should('have.text', 'Password must be at least 8 characters.');
        });

        xit('when the passwords are just right', () => {
            cy.get('#passwd').type('Strong1234');
            cy.get('#conpasswd').type('Strong1234');
            cy.get('[type="submit"]').click();
            cy.get('h2').should('have.text', 'The two passwords provided do not match.');
        });
    });
});
