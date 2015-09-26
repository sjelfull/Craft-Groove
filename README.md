## Groove

Allow you to create tickets in [Groove](http://groovehq.com) from Craft.

## Example

```twig
<form action="">
    <input type="hidden" name="action" value="groove/submitTicket">
    {{ getCsrfInput() }}
    {# Set e-mail and name automatically if user is logged in #}
    {% if currentUser %}
        <input type="hidden" name="email" value="{{ currentUser.email }}" />
        <input type="hidden" name="name" value="{{ currentUser.getName() }}" />

        <p>
            <span class="name">{{ currentUser.getName() }}</span>
            <span class="email">{{ currentUser.email }}</span>
        </p>
        <!-- /.support-form__details -->
    {% else %}
        <label for="support-name">Name</label>
        <input type="text" name="name" id="support-name" required />

        <label for="support-email">E-mail</label>
        <input type="email" name="email" id="support-email" required />
    {% endif %}

    <label for="support-message">Message</label>
    <textarea type="text" name="message" id="support-message" required></textarea>

    <button>Submit</button>
</form>
```