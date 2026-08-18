# 2.9.1-dev24-fix11-fix21 — Dashboard runtime boundary completion

This fix completes the Dashboard 2.0 object boundary. Builder and generated-service configuration remains array-based; runtime presentation data is represented by `DashboardData`, `DashboardWidget`, and the related DTOs.

It removes residual object access on configuration arrays in both generator-time and generated-service code, and fixes the duplicated date-range initialization in the generated Dashboard controller.
