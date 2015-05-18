;
; BIND data file for local loopback interface
;
$TTL	604800
@	IN	SOA	ns.sapdatasheet.com. root.ns.sapdatasheet.com. (
			      2		; Serial
			 604800		; Refresh
			  86400		; Retry
			2419200		; Expire
			 604800 )	; Negative Cache TTL
;
@	IN	NS	ns.sapdatasheet.com.
@	IN	A	166.63.125.80
@	IN	AAAA	::1
ns	IN	A	166.63.125.80
ns1	IN	A	166.63.125.80
ns2	IN	A	166.63.125.80
www	IN	A	166.63.125.80
