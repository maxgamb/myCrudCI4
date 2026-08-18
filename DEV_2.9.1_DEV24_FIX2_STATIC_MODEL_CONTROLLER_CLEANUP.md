# 2.9.1-dev24-fix2 - Static Model & Controller Cleanup

## Goal

Complete the dev24 cleanup by removing the remaining legacy mixed gateway and dynamic cross-table query patterns. Relations are known at generation time, so generated PHP should name the related Model explicitly.

## Generated architecture

```text
READ
Controller -> CurrentModel -> RelatedModel (when a relation is read)

WRITE
Controller -> CurrentService -> CurrentModel
                         -> RelatedService -> RelatedModel

PIVOT
CurrentModel -> pivot table
```

## Rules

- Controllers use `$model` for reads and `$service` for writes in Standard/Full.
- A Model queries its own physical table.
- A cross-resource read is delegated with a static generated call such as `new AddressModel()` or `new PaymentModel()`.
- Related Services are referenced statically by generated code.
- Model method signatures contain only parameters required by enabled features.
- Pivot operations remain in the Model of the resource that owns the generated many-to-many association.

## Examples

```php
// CustomerModel: belongsTo option lookup
return (new StoreModel())->relationOptionRows('store_id', ['store_id'], 'store_id');

// CustomerModel: hasMany lookup
return (new PaymentModel())->childrenByForeignKey('customer_id', $customerId, [...], 'payment_id');

// CustomerService: cross-resource write
$data['address_id'] = (new AddressService())->createRelated($related['address_id']);
```

No registry, service locator, dynamic class name, or runtime table resolver is introduced.
