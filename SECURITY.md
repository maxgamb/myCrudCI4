# Security

myCrudCI4 is a code generator. Generated applications still require normal application security review.

## Reporting

Please report security issues privately to the project maintainers rather than opening a public issue containing exploit details.

## Important deployment guidance

- Never commit `.env` credentials.
- Review generated validation and authorization before production use.
- Protect the Builder and generator routes in real deployments.
- Do not expose write APIs without authentication/authorization.
- Keep uploads outside `public/` unless you deliberately choose otherwise.
- Review `app/Generated/` before publishing into `app/`.
- Use `mycrud:publish --dry-run` before forced publishes on important projects.
