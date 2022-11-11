# Things TO DO / Improvements

### Backend:

- check/fix/remove smtp.gmail.com as mail driver.
- add beanstalk as queue driver and send messages for that.
- beanstalk message queues should be used to update a new table called tickers ... whith price values.
- use tickers table as a sort of cache ...
- double check to see if we can pass an query start_date & end_date in order to improve performance when getting prices
- create a ticker command that will publish messages inside beanstalk queues every x (min, day, week, etc.) this will trigger the beanstalk workers to insert in tickers table.
- Mails should be sent also using the delay function, or add to specialized queues in beanstalk.
- Investigate sharding, master <-> slave or clickhouse clusters to make the db faster.
- check security concerns.


### Frontend:
- fix issues with chart:
    - tooltip not showing or wrong date when it does.
    - bottom axis not showing the correct date strings.
- change form method to get so pages can be bookmarked.
- implement/double check js validation.
- add data tables support
    - data tables price values should be formatted.
    - data tables should work directly with an api.
- company symbol field should be an autocomplete field with <symbol><company-name> option value
