@viewing_products
Feature: Viewing products from a specific manufacturer
    In order to browse products that interest me most
    As a Visitor
    I want to be able to view products from a specific manufacturer

    Background:
        Given the store operates on a channel named "Poland"
        And the store has available manufacturers as "Nikon" and "Sony"
        And the store has a product "T-Shirt Banana" available in "Poland" channel
        And this product belongs to "Nikon"
        And the store has a product "PHP Cap" available in "Poland" channel
        And this product belongs to "Sony"

    @ui
    Scenario: Viewing products from a Nikon manufacturer
        When I browse products from manufacturer "Nikon"
        Then I should see the product "T-Shirt Banana"
        And I should not see the product "PHP Cap"

    @ui
    Scenario: Viewing products from a Sony manufacturer
        When I browse products from manufacturer "Sony"
        Then I should see the product "PHP Cap"
        And I should not see the product "T-Shirt Banana"
