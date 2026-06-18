import 'package:equatable/equatable.dart';
import '../../models/product.dart';

/// CartState holds the current state of the shopping cart
class CartState extends Equatable {
  /// List of products currently in the cart (can have duplicates for quantity)
  final List<Product> cartItems;

  const CartState({this.cartItems = const []});

  /// Total number of items in the cart
  int get totalItems => cartItems.length;

  /// Total price of all items in the cart
  double get totalPrice =>
      cartItems.fold(0, (sum, item) => sum + item.price);

  /// Get quantity of a specific product
  int getQuantity(Product product) =>
      cartItems.where((p) => p.id == product.id).length;

  /// Check if product is already in cart
  bool isInCart(Product product) =>
      cartItems.any((p) => p.id == product.id);

  /// Create a new CartState with updated cart items
  CartState copyWith({List<Product>? cartItems}) {
    return CartState(cartItems: cartItems ?? this.cartItems);
  }

  @override
  List<Object?> get props => [cartItems];
}
