import hashlib

def hashMd5Sha1Sha256(Path):
	BLOCKSIZE = 65536
	hasher = hashlib.md5()
	with open(Path) as afile:
		buf = afile.read(BLOCKSIZE)
		while len(buf) > 0:
			hasher.update(buf)
			buf = afile.read(BLOCKSIZE)
	md5 = hasher.hexdigest()

	hasher = hashlib.sha1()
	with open(Path) as afile:
		buf = afile.read(BLOCKSIZE)
		while len(buf) > 0:
			hasher.update(buf)
			buf = afile.read(BLOCKSIZE)
	sha1 = hasher.hexdigest()

	hasher = hashlib.sha256()
	with open(Path) as afile:
		buf = afile.read(BLOCKSIZE)
		while len(buf) > 0:
			hasher.update(buf)
			buf = afile.read(BLOCKSIZE)
	sha256 = hasher.hexdigest()

	return (md5, sha1, sha256)