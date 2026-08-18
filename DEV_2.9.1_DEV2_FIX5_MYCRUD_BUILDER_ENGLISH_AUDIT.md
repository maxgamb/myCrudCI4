# myCrudCI4 2.9.1-dev2-fix5 — /mycrud and Builder English audit

Audited the three developer-facing entry points:

- `/mycrud`
- `/mycrud/builder`
- `/mycrud/builder/configure/<table>`

Changes:

- developer layout language set to English;
- project dashboard labels/status/actions translated;
- Builder table list translated;
- Builder configure labels/help translated;
- BuilderController/ProjectController visible titles/messages translated;
- obsolete `/mycrud/auto/<table>` action removed from the Builder table list
  because that route is not defined in `MyCrudRoutes`;
- Quick remains a separate global workflow, consistent with the documented
  Builder → saved configuration → Quick/CLI model.
