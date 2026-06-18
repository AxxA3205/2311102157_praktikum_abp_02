import 'package:equatable/equatable.dart';
import '../../models/product.dart';

/// Base class for all Cart Events
abstract class CartEvent extends Equatable {
  const CartEvent();

  @override
  List<Object?> get props => [];
}

/// Event: Add a product to the cart
class AddToCartEvent extends CartEvent {
  final Product product;

  const AddToCartEvent(this.product);

  @override
  List<Object?> get props => [product];
}

/// Event: Remove a product from the cart
class RemoveFromCartEvent extends CartEvent {
  final Product product;

  const RemoveFromCartEvent(this.product);

  @override
  List<Object?> get props => [product];
}

/// Event: Clear all items from the cart
class ClearCartEvent extends CartEvent {
  const ClearCartEvent();
}
