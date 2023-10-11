### How to start:
1. ``docker compose up -d`` - start app in container
2. rename .env.example into .env for root folder (docker) and for src folder (project)
3. ``docker compose exec php vendor/bin/phpunit  --stop-on-failure`` - run tests

### Features and fails 
- tests checking all Task functionality
- Sanctum token auth implemented
- frontend part is not implemented, I haven't made it right so didn't include at all
